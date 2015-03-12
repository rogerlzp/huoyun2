
$(document).ready(function(){
	 $("#J_useNewAddr").on("click",
		        function() {
		 alert("checkout2");
		 $("#J_editAddrBox").show();
	 });
		 /*
		            var b = $(this).attr("data-state");
		            return $(this).attr("data-url") ? (location.href = $(this).attr("data-url"), !1) : 
		            	("off" === b ? (XIAOMI.app.placeholder($("#J_editAddrBox").find("input,textarea")), 
		            			a.Show($(this)), 
		            			XIAOMI.checkOut.setAddrState("1")) : "on" === b && (a.Close(),
		            					a.resetData(), XIAOMI.checkOut.setAddrState()), !1)
		        });
		        */
	  		
	  $("#Provinces").change(function() {

          var b = $(this).val();
          alert("province changed"+b);
          getProvinceData(b);
          
          $("#Citys").prop("disabled", !0).find("option:gt(0)").remove(),
          $("#Countys").prop("disabled", !0).find("option:gt(0)").remove()
      });
	  /*
      $("#Citys").change(function() {
          var b = $(this).val();
          "0" !== b ? (XIAOMI.app.getRegions.getData(b, "Countys"), a.newCity = $(this).find("option:selected").html()) : (a.newCity = null, a.newCounty = null),
          $("#Countys").prop("disabled", !0).find("option:gt(0)").remove()
      }),
      $("#Countys").change(function() {
          var b = $(this).val();
          "0" !== b ? (a.newCounty = $(this).find("option:selected").html(), a.newZipcode = $(this).find("option:selected").attr("zipcode"), $("#zipcodeTip").html("邮编为：" + a.newZipcode)) : (a.newCounty = null, a.newZipcode = null, $("#zipcodeTip").html(""))
      }),
      */
});






