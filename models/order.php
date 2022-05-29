<?php

class Order extends DB {

  public $total_sale = 0;
  
  public function __construct() {
    parent::__construct();
  }
  
  public function save_transaction( $post ) {
    $response = array(
      'error' => false,
      'msg' => ''
    );
    
    require_once( ABSPATH . "models/cart.php" );
    $cart = new Cart();
    
    if ( !empty( $cart->cart ) ) {
      $total = $cart->compute_total();
      
      $data = array(
        'total' => $total,
        'amount' => floatval( $post['amount'] ),
        'payment_type' => $post['payment_type'],
        'customer_id' => (int) $post['customer_id'],
        'comment' => $post['comment'],
        'status' => 'completed',
        'date_ordered' => date( "Y-m-d H:i:s" )
      );
      
      if ( $data['amount'] >= $total ) {
        $is_inserted = $this->insert( "orders", $data );
        
        if ( $is_inserted ) {
          $this->save_order_item( $is_inserted );
          unset( $_SESSION['cart'] );
          
          $response = array( 'error' => false, 'msg' => 'Transaction successfully saved!' ) ;
        } else {
          $response = array( 'error' => true, 'msg' => 'Unable to save transaction' ) ;
        }
      } else {
        $response = array( 'error' => true, 'msg' => 'Amount paid is less than the total amount.' );
      }
    } else {
      $response = array( 'error' => true, 'msg' => 'Unable to save transaction. Cart is empty' );
    }
    
    return $response;
  }
  
  public function save_order_item( $order_id ) {
    $response = array(
      'error' => false,
      'msg' => ''
    );
    
    require_once( ABSPATH . "models/cart.php" );
    require_once( ABSPATH . "models/product.php" );
    $cart = new Cart();
    $product = new Product();
    
    if ( !empty( $cart->cart) ) {
      foreach( $cart->cart as $prod ) {
        $data = array(
          'prod_id' => $prod['prod_id'],
          'qty' => $prod['qty'],
          'order_id' => $order_id
        );
        
        $inserted = $this->insert( "order_items", $data );
        if ( $inserted )
          $product->update_product_qty( $data['prod_id'], $data['qty'], 'decrease' );
      }
    }
  }
  
  public function sales_report() {
    $filter_by = 'year';
    if ( isset( $_GET['filter_by'] ) && !empty( $_GET['filter_by'] ) ) {
      $filter_by  = $_GET['filter_by'];
    }
    $sales_arr = array();
    
    switch ( $filter_by ) {
      case "year":
        $year = ( isset( $_GET['year'] ) ) ? $_GET['year'] : date("Y");
        for( $month = 1; $month <= 12; $month++ ) {
          $month_sql = sprintf( "SELECT IFNULL(SUM(`total`),0) as total_sales FROM `orders` WHERE YEAR(`date_ordered`) = %d AND MONTH(`date_ordered`) = %d", $year, $month);
          $row = $this->get_row( $month_sql );
          $sales_arr[] = $row['total_sales'];
          $this->total_sale = $this->total_sale + $row['total_sales'];
        }
        break;
      case "month":
        $num_months = cal_days_in_month(CAL_GREGORIAN, $_GET['month'], $_GET['year']);
        $year = $_GET['year'];
        $month = $_GET['month'];
        for( $day = 1; $day <= $num_months; $day++ ) {
          $day_sql = sprintf( 
            "SELECT 
              IFNULL(SUM(`total`),0) as total_sales 
            FROM 
              `orders` 
            WHERE  
              YEAR(`date_ordered`) = %d AND 
              MONTH(`date_ordered`) = %d AND 
              DAY(`date_ordered`) = %d",
            $year, $month, $day );
            
          $row = $this->get_row( $day_sql );
          $sales_arr[] = $row['total_sales'];
          $this->total_sale = $this->total_sale + $row['total_sales'];
        }
        break;
      case "day":
        $day = $_GET['day'];
        $day = new DateTime($day);
        $day = $day->format('Y-m-d');
        $sql = sprintf( "SELECT IFNULL(SUM(`total`),0) as total_sales FROM `orders` WHERE DATE(`date_ordered`) = '%s'", $day );
        
        $row = $this->get_row( $sql );
        $sales_arr[] = $row['total_sales'];
        $this->total_sale = $this->total_sale + $row['total_sales'];
        break;
    }
    
    return str_replace( '"',"", json_encode( $sales_arr ) );
  }
  
  public function get_oldest_date_order() {
    $sql = sprintf( "SELECT YEAR(`date_ordered`) as date_ordered FROM `orders` ORDER BY `date_ordered` ASC LIMIT 1" );
    $row = $this->get_row( $sql );
    return $row['date_ordered'];
  }
  
  public function get_year_category() {
    return json_encode( array('Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec') );
  }
  
  public function get_month_category() {
    $days = array();
    $num_months = cal_days_in_month(CAL_GREGORIAN, $_GET['month'], $_GET['year']);
    for( $day = 1; $day <= $num_months; $day++ ) :
      $days[] = $day;
    endfor;
    
    return json_encode( $days );
  }
  
  public function get_day_category() {
    return json_encode( array( $_GET['day'] ) );
  }
}