</div>  
<footer class="text-center">&copy; Copyright 2017 Denis Jojot</footer>
<script>
	$(document).on('click', '.panel-heading span.clickable', function (e) {
    var $this = $(this);
    if (!$this.hasClass('panel-collapsed')) {
        $this.parents('.panel').find('.panel-body').slideUp();
        $this.addClass('panel-collapsed');
        $this.find('i').removeClass('glyphicon-minus').addClass('glyphicon-plus');
    } else {
        $this.parents('.panel').find('.panel-body').slideDown();
        $this.removeClass('panel-collapsed');
        $this.find('i').removeClass('glyphicon-plus').addClass('glyphicon-minus');
    }
});
$(document).on('click', '.panel div.clickable', function (e) {
    var $this = $(this);
    if (!$this.hasClass('panel-collapsed')) {
        $this.parents('.panel').find('.panel-body').slideUp();
        $this.addClass('panel-collapsed');
        $this.find('i').removeClass('glyphicon-minus').addClass('glyphicon-plus');
    } else {
        $this.parents('.panel').find('.panel-body').slideDown();
        $this.removeClass('panel-collapsed');
        $this.find('i').removeClass('glyphicon-plus').addClass('glyphicon-minus');
    }
});
$(document).ready(function () {
    $('.panel-heading span.clickable').click();
    $('.panel div.clickable').click();
});
// GET the values of input type=date and send it back as a value to prepopulate the date fields
//get concept date on plans and milestones
(function () {
    var date = $('#concept_date').val();
    field = document.querySelector('#concept_date');
    field.value = date;
    console.log(field.value);

});
//get design date
(function () {
    var date = $('#design_date').val();
    field = document.querySelector('#design_date');
    field.value = date;
    console.log(field.value);

});
//get technical date
(function () {
    var date = $('#technical_date').val();
    field = document.querySelector('#technical_date');
    field.value = date;
    console.log(field.value);

});
//get test date
(function () {
    var date = $('#test_date').val();
    field = document.querySelector('#test_date');
    field.value = date;
    console.log(field.value);

});
//get start date for project title
(function () {
    var date = $('#start_date').val();
    field = document.querySelector('#start_date');
    field.value = date;
    console.log(field.value);

});
</script>
</body>
</html>