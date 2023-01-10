<?php
			$break_to_avoid_timeout=false;
			$consecutive_emails_error=0;
			$test_smtp=is_array($test_array);
			
			if (!is_array($recipients)) {
				$myobject = new stdClass;
				$myobject->email = $recipients;
				$recipients = array($myobject);
			}
			
			global $knewsOptions, $wpdb;

			if ($knewsOptions['smtp_knews']=='0' && !$test_smtp) {
				$headers='';

				$headers .= 'From: ' . $knewsOptions['from_name_knews'] . ' <' . $knewsOptions['from_mail_knews'] . '>' . "\r\n";
				if ($theHtml != '') add_filter('wp_mail_content_type',create_function('', 'return "text/html";'));

			} else {
				
				if ( !class_exists("PHPMailer") ) require_once ABSPATH . WPINC . '/class-phpmailer.php';
				if ( !class_exists("SMTP") ) require_once ABSPATH . WPINC . '/class-smtp.php';
				
				if ( !class_exists("KnewsPHPMailer")) {
					class KnewsPHPMailer extends PHPMailer {
						public function KnewsSmtpReset() {
							if ($this->smtp !== null and $this->smtp->connected()) {
								return $this->smtp->reset();
							}
						}
					};
				}

				if (!$test_smtp) {

					if (!$smtpdata = $this->get_smtp_multiple($id_smtp)) {
						$smtpdata = $this->get_smtp_multiple(1, true);
						//$smtpdata = $smtpdata[1];
					}
					
					$mail=new KnewsPHPMailer();
					if ($smtpdata['is_sendmail']=='1') {
						$mail->IsSendmail();
					} else {
						$mail->IsSMTP();
					}
					$mail->CharSet='UTF-8';

					if (isset ($knewsOptions['bounce_on']) && $knewsOptions['bounce_on'] == '1') $mail->Sender=$knewsOptions['bounce_email'];
					
					$mail->From = $smtpdata['from_mail_knews'];
					$mail->FromName = $smtpdata['from_name_knews'];
				
					$mail->Host = $smtpdata['smtp_host_knews'];
					$mail->Port = $smtpdata['smtp_port_knews'];
					$mail->Timeout = 30;
	
					if ($smtpdata['smtp_user_knews']!='' || $smtpdata['smtp_pass_knews'] != '') {
		
						$mail->SMTPAuth=true;
						$mail->Username = $smtpdata['smtp_user_knews'];
						$mail->Password = $smtpdata['smtp_pass_knews'];
						if ($smtpdata['smtp_secure_knews'] != '') $mail->SMTPSecure = $smtpdata['smtp_secure_knews'];
					}

				} else {

					$mail=new KnewsPHPMailer();
					if ($test_array['is_sendmail']=='1') {
						$mail->IsSendmail();
					} else {
						$mail->IsSMTP();
					}
					$mail->CharSet='UTF-8';

					//$mail->From = $knewsOptions['from_mail_knews'];
					//$mail->FromName = $knewsOptions['from_name_knews'];
					$mail->From = $test_array['from_mail_knews'];
					$mail->FromName = $test_array['from_name_knews'];

					$mail->Host = $test_array['smtp_host_knews'];
					$mail->Port = $test_array['smtp_port_knews'];
					$mail->Timeout = 30;
					$mail->SMTPDebug=1;
					
					if ($test_array['smtp_user_knews']!='' || $test_array['smtp_pass_knews'] != '') {
		
						$mail->SMTPAuth=true;
						$mail->Username = $test_array['smtp_user_knews'];
						$mail->Password = $test_array['smtp_pass_knews'];
						if ($test_array['smtp_secure_knews'] != '') $mail->SMTPSecure = $test_array['smtp_secure_knews'];
					}
					
				}
				
				if (count($recipients) > 1) $mail->SMTPKeepAlive = true;
			}

			$submit_error=0;
			$submit_ok=0;
			$partial_submit_error=0;
			$partial_submit_ok=0;
			$timer = time();
			$aux_timer = $timer;
			$error_info=array();

			foreach ($recipients as $recipient) {
				$customHtml = $theHtml; $customText = $theText;

				if (isset($recipient->confirm)) {
					$customHtml=str_replace('#url_confirm#', $recipient->confirm, $customHtml);
					$customText=str_replace('#url_confirm#', $recipient->confirm, $customText);
				}
				if (isset($recipient->unsubscribe)) {
					$customHtml=str_replace('%unsubscribe_href%', $recipient->unsubscribe, $customHtml);
					$customText=str_replace('%unsubscribe_href%', $recipient->unsubscribe, $customText);
				}

				if (isset($recipient->cant_read)) {
					$customHtml=str_replace('%cant_read_href%', $recipient->cant_read, $customHtml);
					$customText=str_replace('%cant_read_href%', $recipient->cant_read, $customText);

					$customHtml=str_replace('%mobile_version_href%', $recipient->cant_read . (($mobile) ? '&m=dsk' : '&m=mbl'), $customHtml);
					$customText=str_replace('%mobile_version_href%', $recipient->cant_read . (($mobile) ? '&m=dsk' : '&m=mbl'), $customText);
				}

				if (isset($recipient->fb_like)) {
					$customHtml=str_replace('%fb_like_href%', $recipient->fb_like, $customHtml);
					$customText=str_replace('%fb_like_href%', $recipient->fb_like, $customText);
				}

				if (isset($recipient->tweet)) {
					$customHtml=str_replace('%tweet_href%', $recipient->tweet, $customHtml);
					$customText=str_replace('%tweet_href%', $recipient->tweet, $customText);
				}

				$customSubject=$theSubject;
				if (isset($recipient->tokens)) {
					foreach ($recipient->tokens as $token) {
						$customHtml=str_replace($token['token'], $token['value'], $customHtml);
						$customText=str_replace($token['token'], $token['value'], $customText);
						$customSubject=str_replace($token['token'], $token['value'], $customSubject);
					}
				}

				$customHtml = str_replace('#blog_name#', get_bloginfo('name'), $customHtml);
				$customText = str_replace('#blog_name#', get_bloginfo('name'), $customText);

				$customHtml = str_replace('#news_title_encoded#', urlencode($customSubject), $customHtml);
				$customText = str_replace('#news_title_encoded#', urlencode($customSubject), $customText);

				$customHtml = str_replace('#news_title#', $customSubject, $customHtml);
				$customText = str_replace('#news_title#', $customSubject, $customText);

				if (isset($recipient->confkey)) {
					$customHtml = str_replace('%confkey%', $recipient->confkey, $customHtml);
					$customText = str_replace('%confkey%', $recipient->confkey, $customText);
				}

				$customHtml = $this->htmlentities_corrected($customHtml); $customText = $this->htmlentities_corrected($customText);

				$do_smtp_reset = false;

				if ($knewsOptions['smtp_knews']=='0' && !$test_smtp) {

					$message = (($theHtml!='') ? $customHtml : $customText);
					
					if (strpos($recipient->email , '@knewstest.com') === false) {
						$mail_recipient = $recipient->email;
					} else {
						$mail_recipient = get_option('admin_email');
					}

					if (wp_mail($mail_recipient, $customSubject, $message, $headers)) {
						$submit_ok++;
						$partial_submit_ok++;
						$error_info[]='submit ok [wp_mail()]';
						$status_submit=1;
						$consecutive_emails_error=0;
					} else {
						$submit_error++;
						$partial_submit_error++;
						$error_info[]='wp_mail() error';
						$status_submit=2;
						$consecutive_emails_error++;
					}

				} else {

					$mail->Subject=$customSubject;

					if (strpos($recipient->email , '@knewstest.com') === false) {
						$mail_recipient = $recipient->email;
					} else {
						$mail_recipient = get_option('admin_email');
					}

					$mail->AddAddress($mail_recipient);

					//if ($theHtml != '') $mail->Body=utf8_encode($customHtml);
					//if ($theText != '') $mail->AltBody=utf8_encode($customText);
					if ($theHtml != '') $mail->Body=$customHtml;
					if ($theText != '') $mail->AltBody=$customText;
					if ($theHtml != '') $mail->IsHTML(true);

					if ($mail->Send()) {
						$submit_ok++;
						$partial_submit_ok++;
						$error_info[]='submit ok [smtp]';
						$status_submit=1;
						$consecutive_emails_error=0;
					} else {
						$submit_error++;
						$partial_submit_error++;
						$error_info[]=$mail->ErrorInfo . ' [smtp]';
						$status_submit=2;
						$consecutive_emails_error++;

						$reset_result = $mail->KnewsSmtpReset();	

						$do_smtp_reset = true;
					}
						
					$mail->ClearAddresses();
					$mail->ClearAttachments();
					$mail->ClearCustomHeaders();

				}

				if (count($recipients) > 1) {
					if( !@set_time_limit(25) ) {
						if ($timer + ini_get('max_execution_time') - 4 <= time()) $break_to_avoid_timeout=true;
					}
					echo ' ';
					
					if ($aux_timer + 8 >= time() || $break_to_avoid_timeout) {
						$aux_timer = time();
						$query = "UPDATE " . KNEWS_NEWSLETTERS_SUBMITS . " SET users_ok = users_ok + " . $partial_submit_ok . ", users_error = users_error + " . $partial_submit_error . " WHERE id=" . $idSubmit;
						$result = $wpdb->query( $query );
						$partial_submit_error = 0;
						$partial_submit_ok = 0;
					}

				}

				if (isset($recipient->unique_submit)) {
					$query = "UPDATE " . KNEWS_NEWSLETTERS_SUBMITS_DETAILS . " SET status=" . $status_submit . " WHERE id=" .$recipient->unique_submit;
					$result = $wpdb->query( $query );
				}
				
				if ($fp) {
					$hour = date('H:i:s', current_time('timestamp'));
					fwrite($fp, '  ' . $hour . ' | ' . $recipient->email . ' | ' . $error_info[count($error_info)-1] . "<br>\r\n");

					if ($do_smtp_reset) fwrite($fp, '* Reset SMTP after fail, result: ' . ($reset_result ? '1' : '0') . "<br>\r\n");
				}
				
				/*
				if ($submit_error != 0) {
					for ($i = $submit_ok+1; $i < count($recipients); $i++) {
						if (isset($recipients[$i]->unique_submit)) {
							$query = "UPDATE " . KNEWS_NEWSLETTERS_SUBMITS_DETAILS . " SET status=0 WHERE id=" .$recipients[$i]->unique_submit;
							$unlock = $wpdb->query( $query );
						}
					}
					//break;
				}
				*/
				if ($break_to_avoid_timeout || $consecutive_emails_error > 4) {

					$query = "UPDATE " . KNEWS_NEWSLETTERS_SUBMITS_DETAILS . " SET status=0 WHERE status=3 AND submit=" . $idSubmit;
					$restart = $wpdb->query( $query );

					if ($fp) {
						if ($break_to_avoid_timeout) {
							fwrite($fp, '* Your webserver are run under safe mode, terminating the script to avoid the PHP timeout error... (' . $hour . ') ' . "<br>\r\n");
						} else {
							fwrite($fp, '* Too much consecutive submissions error. Let\'s stop & wait next cycle... (' . $hour . ') ' . "<br>\r\n");							
						}
					}
					break;
				}
			}
		
			if (count($recipients) > 1 && ($knewsOptions['smtp_knews']!='0') || $test_smtp) $mail->SmtpClose();
			
			$reply = array('ok'=>$submit_ok, 'error'=>$submit_error, 'error_info'=>$error_info, 'break_to_avoid_timeout' => $break_to_avoid_timeout, 'too_consecutive_emails_error'=> $consecutive_emails_error > 4);
