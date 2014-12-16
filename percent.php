<textarea class="percentTA" id="percent" ></textarea>
<div class="percentageDiv">
	<div class="glass">
		<span class="liquid" id="liquid"/>
	</div>
	<p id ="percentage" class="percentage"></p>
</div>

<script  type="text/javascript">

	function updatePercent(val) {
		var arr = val.split(":");
		var h = arr[0];
		var p = arr[1];
		
		document.getElementById("liquid").style.height = h;
		document.getElementById("percentage").innerHTML = p;
	};
			
	jQuery(document).ready(function() {
	   var refreshId = setInterval(function() {
		  jQuery("#percent").load("percentHelper.php");
		  updatePercent(document.getElementById("percent").value);
	   }, 500);
	});
</script>