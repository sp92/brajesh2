<div class="w3l_banner_nav_left">
			<nav class="navbar nav_bottom">
			 <!-- Brand and toggle get grouped for better mobile display -->
			  <div class="navbar-header nav_2">
				  <button type="button" class="navbar-toggle collapsed navbar-toggle1" data-toggle="collapse" data-target="#bs-megadropdown-tabs">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				  </button>
			   </div> 
			   <!-- Collect the nav links, forms, and other content for toggling -->
				<div class="collapse navbar-collapse" id="bs-megadropdown-tabs">
					<ul class="nav navbar-nav nav_1">

					<?								
								 $sqlf = "select * from category where cat_active=1 and cat_lang='E' order by cat_seq, cat_title limit 0,15";
								 $catListf = mysql_query($sqlf);
								 while($rowf=mysql_fetch_array($catListf))
								 {
									
									 $sqld = "select distinct s.subcat_id, s.* from subcategory s, products p where s.subcat_id = p.prod_subcat and s.cat_id=p.prod_cat and s.subcat_active=1 and s.cat_id=".$rowf["cat_id"]." order by s.subcat_seq, s.subcat_title";
									 $subcatListtt = mysql_query($sqld);
									 $num_rowsss = mysql_num_rows($subcatListtt);	
									 if ($num_rowsss > 0)			 
									 {
										
							?>
						<li><a href="#"><? echo $rowf["cat_title"];?></a></li>
					
						<li class="dropdown mega-dropdown active">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown"><? echo $rowf["cat_title"];?><span class="caret"></span></a>				
							<div class="dropdown-menu mega-dropdown-menu w3ls_vegetables_menu">
								<div class="w3ls_vegetables">
									<ul>	
									  <?  while($row1t=mysql_fetch_array($subcatListtt)) {?>
										<li><a href="vegetables.html"><?=$row1t["subcat_title"]; ?></a></li>
									<? }?> 
									</ul>
								</div>                  
							</div>				
						</li>
						          <? } else{?>
						      <li><a href="#"><? echo $rowf["cat_title"];?></a></li>  
						      
						           <? } }?>  
					</ul>
				 </div><!-- /.navbar-collapse -->
			</nav>
		</div>