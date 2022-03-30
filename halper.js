$("#formSubmit").submit(function () {
	$(this).find(":submit").css("pointer-events", "none").val('Submitted...');
});

str_replace(',', '', $this->input->post('payment'))
<input type="text" id="payment" onkeyup="getNumberFormate('payment')">
function getNumberFormate(id){

	var number = $('#'+id).val().replaceAll(',', '');

	if(number.length >= 4){
		var output = new Intl.NumberFormat('en-IN', {currency: 'INR' }).format(number);
		$('#'+id).val(output);
	}else{
		$('#'+id).val(number);
	}
}

// time function
function startTime() {
	const date  = new Date();
	var hours   = date.getHours();
	var minutes = date.getMinutes();
	var second  = date.getSeconds();
	var ampm = hours >= 12 ? 'PM' : 'AM';
	
	hours = hours % 12;
	hours = hours ? hours : 12; // the hour '0' should be '12'
	minutes = minutes < 10 ? '0'+minutes : minutes;
  
  document.getElementById('watch').innerHTML =   hours + ':' + minutes + ' ' + second + ' ' + ampm;
  setTimeout(startTime, 1000);
}
startTime();


// convert number
var numbers = { '০': 0, '১': 1, '২': 2, '৩': 3, '৪': 4, '৫': 5, '৬': 6, '৭': 7, '৮': 8, '৯': 9 };

function replaceNumbers(input) {
  var output = [];
  for (var i = 0; i < input.length; ++i) {
    if (numbers.hasOwnProperty(input[i])) {
      output.push(numbers[input[i]]);
    } else {
      output.push(input[i]);
    }
  }
  return output.join('');
}
document.getElementById('r').textContent = replaceNumbers('১');





// onscroll data load
<table class="table table-bordered" style="margin-bottom: 0px;">
	<thead>
		<tr>
			<tr>
				<th width="20">Sl</th>
				<th>Student's Name</span></th>
				<th>College Roll</th>
				<th>Ssc Roll</th>
				<th>District</th>
				<th>Phone</th>
				<th>Pass</th>
				<th>Group</th>
				<th>Religion</th>
				<th class="none" style="width: 180px !important">Action</th>
			</tr>
		</tr>
	</thead>
	<tbody id="dataList"> </tbody>
</table>
<p class="text-center" style="margin-bottom: 0px; padding-top: 10px;">&nbsp;  <span class="loadMore">Loading more data.......</span> </p>

<script>
$(document).ready(function(){
    var dataList = document.querySelector('#dataList');
    
    var limit_offset = 0;
    var limit  = 50;
    var slNo = 0;
    
    var loadMore = function(limit_offset, limit) {
        
        $(".loadMore").fadeIn();
        
       $.post( "<?= site_url()?>/apply_now/apply_now/loadData", { 
           limit_offset: limit_offset, 
           limit       : limit,
           college_id  : "<?= (!empty($_POST['college_id']) ? $_POST['college_id'] : '') ?>",
           hsc_session : "<?= (!empty($_POST['hsc_session']) ? $_POST['hsc_session'] : '') ?>",
           group       : "<?= (!empty($_POST['group']) ? $_POST['group'] : '') ?>",
       }).success(function(response) {
           
           var data = JSON.parse(response);
           if(Object.values(data).length > 0){
               
                $.each(data, function(index, row) {
                    
                    var item = '<tr>';
                        item += `<td>${++slNo}</td>
                                <td>${row.name_english}</td>
                                <td>${row.college_id}</td>
                                <td>${row.roll_no}</td>
                                <td>${row.district}</td>
                                <td>${row.student_phone}</td>
                                <td>${row.password}</td>
                                <td>${row.group}</td>
                                <td>${row.religion}</td>
                                <td class="none text-center">
                                    <a class="btn btn-info" href="<?php echo base_url('apply_now/apply_now/view'); ?>/${row.id}"><i class="fa fa-eye"></i></a>
                                    <a class="btn btn-warning" href="<?php echo base_url('apply_now/apply_now/edit'); ?>/${row.id}"><i class="fa fa-pencil-square-o"></i></a>
                                    <a class="btn btn-primary" title="Vital Academic Record" target="_blank" href="<?php echo base_url('apply_now/apply_now/academicRecord'); ?>/${row.college_id}"><i class="fa fa-link" aria-hidden="true"></i></a>
                                    <a class="btn btn-success" target="_blank" href="<?php echo base_url('apply_now/apply_now/more'); ?>/${row.college_id}"><i class="fa fa-plus"></i></a>
                                    <a class="btn btn-danger" onclick="return confirm('Are you sure to delete this Data?');" href="<?php echo base_url('apply_now/apply_now/deleteStudent'); ?>/${row.id}"><i class="fa fa-trash"></i></a>
                                </td>
                                `;
                        item += '</tr>';
                        
                    dataList.innerHTML += item;
                    
                });
                 $(".loadMore").fadeOut();
           }else{
               $(".loadMore").text("No record found!");
               $(".loadMore").fadeOut(2000);
           }
      });
      
    }
    
    // Detect when scrolled to bottom.
    $(window).scroll(function(){
      if($(window).scrollTop() == ($(document).height() - $(window).height())){
          
          limit_offset += limit;
          loadMore(limit_offset, limit);
      }
    });
    
    // Initially load some items.
    loadMore(limit_offset, limit);
});
</script>