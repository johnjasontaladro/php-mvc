(function($) {
  "use strict";
  
  $(function() {
    
    /*****************************************
     * Helper functions
     *****************************************/
    function number_format( price ) {
      return parseFloat(Math.round(price * 100) / 100).toFixed(2);
    }
    
    /*****************************************
     * Template function
     *****************************************/
    function template_cart( item ) {
      var _list = "";
      $.each( item, function( index, val ) {
        _list += "<tr>";
          _list += "<td><input type='text' class='text-right qty number' data-prod-id='" + val.prod_id + "' value='" + val.qty + "'></td>";
          _list += "<td>" + val.product_name + "</td>";
          _list += "<td class=\"text-right\">Php " + number_format( val.selling_price ) + "</td>";
          _list += "<td class=\"text-right\">Php " + number_format( (val.qty * val.selling_price) ) + "</td>";
          _list += "<td>";
            _list += "<a href=\"javascript:void(0);\" class=\"increase-item\" data-prod-id=\"" + val.prod_id + "\"><span title=\"increase item\" alt=\"increase item\" class=\"glyphicon glyphicon-plus-sign\"></span></a> ";
            _list += "<a href=\"javascript:void(0);\" class=\"decrease-item\" data-prod-id=\"" + val.prod_id + "\"><span title=\"decrease item\" alt=\"decrease item\" class=\"glyphicon glyphicon-minus-sign\"></span></a> ";
            _list += "<a href=\"javascript:void(0);\" class=\"remove-item\" data-cart-key=\"" + index + "\"><span title=\"remove item\" alt=\"remove item\" class=\"glyphicon glyphicon-remove-sign\"></span></a>";
          _list += "</td>";
        _list += "</tr>";
      });
      
      return _list;
    }
    
    function compute_subtotal( cart ) {
      var 
        subtotal = 0,
        prod_total = 0;
        
      $.each( cart, function( index, val ) {
        prod_total = ( parseInt( val.qty, 10 ) * parseFloat( val.selling_price ) );
        subtotal += prod_total;
      });
      
      return subtotal;
    }
    
    function compute_total( cart ) {
      var tax = 0;
      
      return compute_subtotal( cart ) + tax;
    }
    
    function compute_change( amount ) {
      var total = parseFloat( $("#total-amount-value").val() );
      
      return amount - total;
    }
    
    function clear_cart() {
      $("#item-list").html("");
      $("#sub-total, #total-amount, #change-amount").number( 0, 2 );
      $("#change-label").addClass("hidden");
      $("#amount-pay, #order-comment").val("");
      $("#customer").select2("val", "");
      $("#total-amount-value").val("0");
      $("#save-transaction").attr("disabled", "disabled");
    }
    
    function load_html_product_dropdown() {
      return $.ajax({
        type: "POST",
        url: APP.ajax_url,
        data: {
          'token' : APP.session_token,
          'action' : 'html_product_dropdown'
        },
        beforeSend: function() {
        },
        success: function( response ) {
          $("#search-products")
            .select2("destroy")
            .html( response )
            .select2({
              placeholder: "Start Typing Item Name",
              allowClear: true
            });
        }
      });
    }
    
    /******************************************
     * Cart function
     ******************************************/
    function update_cart_table( _data  ) {
      $(".preloader", ".table-cart-wrapper").remove();
            
      $.ajax({
        type: "POST",
        url: APP.ajax_url,
        data: _data,
        beforeSend: function() {
          $(".table-cart-wrapper").append("<div class='preloader'></div>");
        },
        success: function( response ) {
          var 
            item = $.parseJSON( response );
                        
          $(".preloader", ".table-cart-wrapper").remove();            
          if ( item.error === false) {
            $("#item-list").html( template_cart( item.cart ) );
            $("#sub-total").number( compute_subtotal( item.cart ), 2 );
            $("#total-amount").number( compute_total( item.cart ), 2 );
            $("#total-amount-value").val( compute_total( item.cart ) );
          } else {
            alert( item.msg );
          }
          $("#search-products").select2("val", "");
          $("input.number").number( true );
        }
      });
      
    }
    
    
      
    $("#search-products").select2({
      placeholder: "Start Typing Item Name",
      allowClear: true
    });
    
    $("#customer").select2({
      placeholder: "Start Typing Name...",
      allowClear: true
    });
    
    $("#add-item-to-cart").click(function() {
      var 
        product_id = $("#search-products").val(),
        _data = {
          'product_id' : product_id,
          'token' : APP.session_token,
          'action' : 'add_to_cart'
        };
      if ( parseInt( product_id, 10 ) > 0 ) {
        update_cart_table( _data );
      }
    });
    
    $(".table-cart").on("keyup", "input.qty", function(e) {
      if ( e.which == 13 ) {
        var 
          product_id = $(this).data("prod-id"),
          qty = parseInt( $(this).val() ),
          _data = {
            'product_id' : product_id,
            'qty' : qty,
            'token' : APP.session_token,
            'action' : 'add_to_cart'
          };
          
        if ( parseInt( product_id, 10 ) > 0 ) {
          update_cart_table( _data );
        }
      }
    });
    
    $(".table-cart").on("click", ".increase-item", function() {
      var 
        product_id = $(this).data("prod-id"),
        _data = {
          'product_id' : product_id,
          'token' : APP.session_token,
          'action' : 'add_to_cart'
        };
        
      if ( parseInt( product_id, 10 ) > 0 ) {
        update_cart_table( _data );
      }
    });
    
    $(".table-cart").on("click", ".decrease-item", function() {
      var 
        product_id = $(this).data("prod-id"),
        _data = {
          'product_id' : product_id,
          'token' : APP.session_token,
          'action' : 'decrease_product'
        };
      if ( parseInt( product_id, 10 ) > 0 ) {
        update_cart_table( _data );
      }
    });
    
    $(".table-cart").on("click", ".remove-item", function() {
      if ( confirm("Are you sure you want to delete this item?") ) {
        var 
          cart_key = $(this).data("cart-key"),
          _data = {
            'cart_key' : cart_key,
            'token' : APP.session_token,
            'action' : 'remove_from_cart'
          }
        
        if ( parseInt( cart_key, 10 ) >= 0 ) {
          update_cart_table( _data );
        }
      }
    });
    
    $(".form-ajax").submit(function(e) {
      e.preventDefault();
      return false;
    });
    
    $("#amount-pay").number( true, 2 );
    
    $("#amount-pay-btn").click(function() {
      var 
        amount = parseFloat( $("#amount-pay").val() ),
        total = parseFloat( $("#total-amount-value").val() );
      
      if ( total == 0 ) {
        alert("Error! No product entered.");
      } else if ( amount >=  total ) {
        $("#change-amount").number( compute_change( amount ), 2 );
        $("#change-label").removeClass("hidden");
        $("#save-transaction").removeAttr("disabled");
      } else {
        alert("Error! You paid less than the total amount.");
        $("#change-amount").number( 0, 2 );
        $("#change-label").addClass("hidden");
        $("#save-transaction").attr("disabled", "disabled");
        $("#amount-pay").focus();
      }      
    });
    
    $("#amount-pay").bind("keyup", function(e) {
      var code = e.keyCode || e.which;
      if ( code == 13) {
        $("#amount-pay-btn").focus();
      }
    });
    
    $("#save-transaction").click(function() {
      var
        _this = $(this),
        total = parseFloat( $("#total-amount-value").val() ),
        amount = parseFloat( $("#amount-pay").val() ),
        payment_type = $("#payment-type").val(),
        customer_id = $("#customer").val(),
        comment = $("#order-comment").val();
        
      if ( amount >= total ) {
        $.ajax({
          type : "POST",
          url : APP.ajax_url,
          dataType: "json",
          data : {
            'amount' : amount,
            'payment_type' : payment_type,
            'customer_id' : customer_id,
            'comment' : comment,
            'token' : APP.session_token,
            'action' : 'save_transaction'
          },
          beforeSend: function() {
            _this.button('loading');
          },
          success: function( response ) {
            if ( !response.error ) {
              $.when( load_html_product_dropdown() ).done(function( a ) {
                clear_cart();
                _this.button('complete');
                setTimeout( function(){ 
                  _this
                    .button('reset')
                    .attr("disabled", "disabled");
                }, 500 );
              });
              
            } else {
              _this
                .removeClass("btn-success")
                .addClass("btn-danger")
                .button('Error saving!');
                alert( response.msg );
              setTimeout( function(){ 
                _this
                  .removeClass("btn-danger")
                  .addClass("btn-success")
                  .button('reset');
              }, 3000 );
            }
            
          }
        });
      } else {
        alert("Error! Unable to complete transaction. Amount paid is less than the total amount");
        $("#change-amount").number( 0, 2 );
        $("#change-label").addClass("hidden");
        $("#save-transaction").attr("disabled", "disabled");
        $("#amount-pay").focus();
      }
    });
    
    /**
     * Cancel Sale
     */
    $("#cancel-sale").click(function() {
      var _this = $(this);
      
      if ( confirm( "Are you sure you want to cancel transaction?" ) ) {
        $.ajax({
          type: "POST",
          url: APP.ajax_url,
          data: {
            'token' : APP.session_token,
            'action' : 'cancel_sale'
          },
          beforeSend: function() {
            _this.button('loading');
          },
          success: function( response ) {
            clear_cart();
            _this.button('complete');
              setTimeout( function(){ 
                _this
                  .button('reset')
                  .attr('disabled', 'disabled');
              }, 3000 );
          }
        });
      }
    });
    
    
    /******************************************
     * Report function
     ******************************************/
     
    if ( $('.sales-report').length > 0 ) {
      $('.sales-report').highcharts({
          chart: {
              type: 'line'
          },
          title: {
              text: SALES.title
          },
          subtitle: {
              text: SALES.subtitle
          },
          xAxis: {
              categories: SALES.category
          },
          yAxis: {
              title: {
                  text: 'Amount (Pesos)'
              },
              floor: 0
          },
          plotOptions: {
              line: {
                  dataLabels: {
                      enabled: true
                  },
                  enableMouseTracking: false
              }
          },
          series: [{
              name: 'Sales',
              data: SALES.data
          }]
      });
    }    
    
    if ( $.fn.datetimepicker ) {
      $('.date').datetimepicker({
        pickTime: false
      });
    }
    
    $('#filter-by').on("change", function() {
      var _filter = $(this).val();
      if ( $.trim( _filter) !== "" ) {
        $("div[class^='form-group filter-']", "#filter-report").addClass("hidden");
        $(".filter-" + _filter, "#filter-report").removeClass("hidden");
        $(".filter-submit", "#filter-report").removeClass("hidden");
        if ( _filter == "month" ) {
          $(".filter-year", "#filter-report").removeClass("hidden");
        }
      } else {
        $("div[class^='form-group filter-']", "#filter-report").addClass("hidden");
      }
    });
    /* $.getJSON('http://www.highcharts.com/samples/data/jsonp.php?filename=aapl-c.json&callback=?', function (data) {
        console.log(data);
    }); */
    
  });
  
})(jQuery);