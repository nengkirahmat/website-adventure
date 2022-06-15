    </div>
</div>

  <script>
    $(".input-group.date").datepicker({autoclose: true, todayHighlight: true});
    </script>
    <script>
$(function() { 
  $('#tgl1').datetimepicker({
   locale:'id',
   format:'YYYY/MM/DD'
   });
   
  $('#tgl2').datetimepicker({
   useCurrent: false,
   locale:'id',
   format:'YYYY/MM/DD'
   });
   
   $('#tgl1').on("dp.change", function(e) {
    $('#tgl2').data("DateTimePicker").minDate(e.date);
  });
  
   $('#tgl2').on("dp.change", function(e) {
    $('#tgl1').data("DateTimePicker").maxDate(e.date);
      CalcDiff()
   });
  
});


function CalcDiff(){
var a=$('#tgl1').data("DateTimePicker").date();
var b=$('#tgl2').data("DateTimePicker").date();
    var timeDiff=0
    var hari=0
     if (b) {
            timeDiff = (b - a) / 1000;
        }
    hari=Math.floor(timeDiff/(86400));
    if (hari>0){
      $('#selisih').val(hari);
    }else{ $('#selisih').val(1); }
  var a=document.getElementById("selisih").value;
    var b=document.getElementById("st").value;
    var total=parseInt(a)*parseInt(b);
    if (!isNaN(total)){
    document.getElementById("total").innerHTML=total;
    document.getElementById("gtotal").value=total;
    }
}
</script>

    <script src="bootstrap-datetimepicker.js"></script>

<!-- jQuery

    <script src="bs/vendors/jquery/dist/jquery.min.js"></script>
    -->

    <script src="bs/vendors/bootstrap/dist/js/bootstrap.min.js"></script>
   
    <script src="bs/vendors/fastclick/lib/fastclick.js"></script>
    <!-- NProgress -->
    <script src="bs/vendors/nprogress/nprogress.js"></script>
     <!-- Datatables -->
    <script src="bs/vendors/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="bs/vendors/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
    <script src="bs/vendors/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
    <script src="bs/vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js"></script>
    <script src="bs/vendors/datatables.net-buttons/js/buttons.flash.min.js"></script>
    <script src="bs/vendors/datatables.net-buttons/js/buttons.html5.min.js"></script>
    <script src="bs/vendors/datatables.net-buttons/js/buttons.print.min.js"></script>
    <script src="bs/vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js"></script>
    <script src="bs/vendors/datatables.net-keytable/js/dataTables.keyTable.min.js"></script>
    <script src="bs/vendors/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <script src="bs/vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js"></script>
    <script src="bs/vendors/datatables.net-scroller/js/dataTables.scroller.min.js"></script>
    <!-- Custom Theme Scripts -->
    <script src="bs/build/js/custom.min.js"></script>
</body>
</html>