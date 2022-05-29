<?php

if ( !is_login() )
  redirect( site_url( 'login' ) );
  
require_once(ABSPATH . "functions/helpers.php");
require_once(ABSPATH . "models/order.php");
$order = new Order();

$data['sales_data'] = $order->sales_report();
$data['oldest_year_order'] = $order->get_oldest_date_order();
$data['current_year'] = date("Y");

$data['sales_report_title'] = 'Yearly Average Sale';
$data['sales_report_category'] = $order->get_year_category();

if ( isset( $_GET['filter_by'] ) ) :
  if ( 'month' == $_GET['filter_by'] ) :
    $data['sales_report_title'] = 'Monthly Average Sale';
    $data['sales_report_category'] = $order->get_month_category();
  elseif ( 'week' == $_GET['filter_by'] ) :
    $data['sales_report_title'] = 'Weekly Average Sale';
  elseif ( 'day' == $_GET['filter_by'] ) :
    $data['sales_report_title'] = 'Daily Average Sale';
    $data['sales_report_category'] = $order->get_day_category();
  endif;
endif;

$data['sales_report_total_sale'] = $order->total_sale;

$data['title'] = 'Reports';
$data['css'] = array( 
  array( 'relative' => true, 'link' => 'assets/js/select2-3.5.1/select2' ), 
  array( 'relative' => true, 'link' => 'assets/js/select2-3.5.1/select2-bootstrap' ), 
  'bootstrap-datetimepicker.min', 'dashboard' 
);
$data['js'] = array( 
  'jquery.min', 'bootstrap.min', 
  array( 'relative' => true, 'link' => 'assets/js/select2-3.5.1/select2' ),
  'jquery.number.min', 
  array( 'relative' => true, 'link' => 'assets/js/highcharts/js/highcharts' ),
  array( 'relative' => true, 'link' => 'assets/js/highcharts/js/modules/exporting' ),
  'moment', 'bootstrap-datetimepicker.min', 'global', 'app' 
);

$data['user'] = $_SESSION[ VAR_PREFIX . 'user' ];

load_view( 'includes/header_view', $data );
load_view( 'includes/header_nav_view', $data );
load_view( 'reports_view', $data );
load_view( 'includes/footer_view', $data );