(function($) {
  'use strict';


  /*---------------------
   ----- COLUMN CHART -----
   ---------------------*/

  $(function() {

    var data = [
      ["January", 10],
      ["February", 8],
      ["March", 4],
      ["April", 13],
      ["May", 17],
      ["June", 9]
    ];

    if ($("#column-chart").length) {
      $.plot("#column-chart", [data], {
        series: {
          bars: {
            show: true,
            barWidth: 0.6,
            align: "center"
          }
        },
        xaxis: {
          mode: "categories",
          tickLength: 0
        },

        grid: {
          borderWidth: 0,
          labelMargin: 10,
          hoverable: true,
          clickable: true,
          mouseActiveRadius: 6,
        }

      });
    }
  });



})(jQuery);
