</div>
<span style="margin-left: auto; margin-right: auto; color: #fff;">(C)<?php echo date("Y"); ?> OccupyTheSystem.Org. | <a href="<?php echo URL; ?>index/contact" style="color: #fff;">Contact Us</a> - <a href="<?php echo URL; ?>index/policy" style="color: #fff;">Privacy Policy</a>
    </div>
	<script>
	//Add nicEditors
	bkLib.onDomLoaded(function() {
		//nicEditors.allTextAreas({buttonList : ['bold','italic','underline','strikeThrough','html','link']});
                get_notif();
	});
        
        function get_notif(){
            $.getJSON("/dashboard/_getNotificationNumber")
            .done(function(data) {
                //alert(data.number);
                $("span#notifications").html("("+data.number+")")
                if (data.notify == 'true') {
                    $("span#notifications").css('color','red');
                }else{
                    $("span#notifications").css('color','#fff');
                }
                
                setTimeout(function(){get_notif();}, 10000);
            });
    
        }
	</script>
</body>
</html>