
			<div id='styled_popup' name='styled_popup'>
				<table cellpadding='0' cellspacing='0' border='0'>
					<tr>
					<td><img height='23' width='356' src='images/titlebar.jpg'></td>
					<td><a href='javascript:styledPopupClose();'><img height='23' width='24' src='images/x11_close.gif' border='0'></a></td>
					</tr>
					<tr><td colspan='2' style='background-color:#EFEFE7; width: 380px; height: 250px;'>
								<h3>&nbsp&nbsp&nbsp&nbsp New Comment:</h3>
								<form name="new_comment" onsubmit="addComment()" method="POST">
									<textarea rows="10" cols="44" name="comment_text" onKeyDown="limitText(this.form.comment_text,this.form.countdown,1000);" onKeyUp="limitText(this.form.comment_text,this.form.countdown,1000);"></textarea>
									<div style="text-align:center">
										<p style="font-size:0.65em">You have <input readonly type="text" name="countdown" size="2" value="1000" style="font-size:0.65em"> characters left.</p>
										<input type="submit" name="submit3" value="Add"></input>&nbsp&nbsp
										<input type="reset" name="reset" value="Reset"></input>
									</div>
								</form>
						<?php
						if(isset($_POST['submit3'])) { 
							unset($_POST['submit3']);
							$user->addComment($_POST['comment_text'],$_SESSION['comment_id']);
							header("Location:user_page.php");
						}
						?>
						</td></tr>
					</table>
			</div>