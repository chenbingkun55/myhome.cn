<script>
	$(document).ready(function(){
		$('menu').change(function(){
			var orgLevel = this.name;
			var nextMenu = $(this).parents().next().children[0];
			var postUrl = '/xml.xml';

			if(orgLevel == 'resource') return true;

			if(this.value==''){
				var firstOption = nextMenu.option[0];
				nextMenu.length=0;
				nextMenu.options.add(firstOption);
				return true;
			}

			$.post(postUrl,{orgFlag:orgLevel,orgCode:this.value},function(xml){
				var dicts = $('dict',xml);
				if(dicts.length < 1 ){ alert('返回数据错误,请重新登陆'); return false;}
				if(nextMenu.options[0].value==''){
					var firstOption = nextMenu.options[0].text;
					nextMenu.options.add(new Option(firstOption,''));
				}else{
					nextMenu.length = 0;
				}

				for(var i=0;i<dicts.length; i++){
					var newOption = new Option($('name',dicts[i]).text(),$('code',dicts[i]).text());
					nextMenu.options.add(newOption);
				}
			});
		});
	});
</script>