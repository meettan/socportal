
  </div>  <!--  Div End For Getting Ajax data and page  -->
</div>
</div>
<script>
$(document).ready(function() {
    $('#example').DataTable();
} );	
</script>
<script>
			function generatePDF() {
				// Choose the element that our invoice is rendered in.
				const element = document.getElementById('divToPrint');
				// Choose the element and save the PDF for our user.
				html2pdf().from(element).save();
			}
		</script>
<script src="{{ url('public/js/bootstrap.min.js') }}"></script>
<script src="{{ url('public/js/main_javascript.js') }}"></script>
<script src="{{ url('public/js/main_jquery.js') }}"></script>
</body>
</html>