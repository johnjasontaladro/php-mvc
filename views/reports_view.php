<div class="container-fluid">
  <div class="row">
    <?php load_view( 'includes/sidebar_view' ); ?>
    <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
      <div class="panel panel-primary">
        <div class="panel-heading">
          <h3 class="panel-title"><span class="glyphicon glyphicon-list-alt"></span> Sales Report</h3>
        </div>
        <div class="panel-body">
          <div class="filter-report">
            <form class="form-inline" id="filter-report" role="form" method="GET">
              <div class="form-group">
                <label for="filter-by">Filter by</label>
                <select class="form-control" id="filter-by" name="filter_by">
                  <option value="">-Choose-</option>
                  <option value="year" <?php echo ( isset( $_GET['filter_by'] ) ) ? selected( $_GET['filter_by'], 'year', false ) : ''; ?>>Year</option>
                  <option value="month" <?php echo ( isset( $_GET['filter_by'] ) ) ? selected( $_GET['filter_by'], 'month', false ) : ''; ?>>Month</option>
                  <option value="week" <?php echo ( isset( $_GET['filter_by'] ) ) ? selected( $_GET['filter_by'], 'week', false ) : ''; ?>>Week</option>
                  <option value="day" <?php echo ( isset( $_GET['filter_by'] ) ) ? selected( $_GET['filter_by'], 'day', false ) : ''; ?>>Day</option>
                </select>
              </div>
              <div class="form-group filter-day<?php echo ( isset( $_GET['filter_by'] ) && 'day' == $_GET['filter_by'] ) ? '' : ' hidden'; ?>">
                <div class="input-group date">
                  <div class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></div>
                  <input class="form-control" type="text" name="day" placeholder="Choose Date" data-date-format="MM/DD/YYYY" data-date-maxDate="<?php echo date("m/d/Y"); ?>">
                </div>
              </div>
              <div class="form-group filter-week<?php echo ( isset( $_GET['filter_by'] ) && 'week' == $_GET['filter_by'] ) ? '' : ' hidden'; ?>">
              </div>
              <div class="form-group filter-month<?php echo ( isset( $_GET['filter_by'] ) && 'month' == $_GET['filter_by'] ) ? '' : ' hidden'; ?>">
                <div class="input-group">
                  <div class="input-group-addon">Month</div>
                  <select class="form-control" name="month">
                    <?php for ( $m = 1; $m <= 12; $m++ ) : ?>
                    <option value="<?php echo $m; ?>" <?php echo ( isset( $_GET['month'] ) ) ? selected( $_GET['month'], $m, false ) : ''; ?>><?php echo date( 'F', mktime( 0, 0, 0, $m, 1 ) ); ?></option>
                    <?php endfor; ?>
                  </select>
                </div>
              </div>
              <div class="form-group filter-year<?php echo ( isset( $_GET['filter_by'] ) && ( 'year' == $_GET['filter_by'] || 'month' == $_GET['filter_by'] ) ) ? '' : ' hidden'; ?>">
                <div class="input-group">
                  <div class="input-group-addon">Year</div>
                  <select class="form-control" name="year">
                    <?php while( $data['current_year'] >= $data['oldest_year_order'] ) : ?>
                    <option <?php echo ( isset( $_GET['year'] ) ) ? selected( $_GET['year'], $data['current_year'], false ) : ''; ?>><?php echo $data['current_year']; ?></option>
                    <?php $data['current_year']--; endwhile; ?>
                  </select>
                </div>
              </div>
              <div class="form-group filter-submit<?php echo ( isset( $_GET['filter_by'] ) ) ? '' : ' hidden'; ?>">
                <button type="submit" class="btn btn-primary">Filter</button>
              </div>
            </form>
          </div>
          <div class="sales-report"></div>
        </div>
      </div>
      
    </div>
  </div>
</div>
<script type="text/javascript">
  /* <![CDATA[ */
  var SALES = { 
    "data" : <?php echo $data['sales_data']; ?>, 
    "category" : <?php echo $data['sales_report_category']; ?>, 
    "title" : "<?php echo $data['sales_report_title']; ?>",  
    "subtitle" : "Total Sale : Php <?php echo number_format( $data['sales_report_total_sale'], 2 ); ?>"
  };      
  /* ]]> */
</script>