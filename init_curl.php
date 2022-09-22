<?php
    $headers =  [
		"Content-Type: application/json",
        "Authorization: Bearer api_live.4UDet5+nRsTRfFM1KcLjsIZ/SqPruNUZURZqrveR/TdGyzIrUfAvyetjkgMh9DZt",
		"Access-Control-Allow-Origin: *",
        "Access-Control-Allow-Headers: Authorization, Content-Type, If-Match, If-Modified-Since, If-None-Match, If-Unmodified-Since, X-GitHub-OTP, X-Requested-With",
        "Access-Control-Expose-Headers: ETag, Link, X-GitHub-OTP, x-ratelimit-limit, x-ratelimit-remaining, x-ratelimit-reset, X-OAuth-Scopes, X-Accepted-OAuth-Scopes, X-Poll-Interval"
    ];
	
    $link = curl_init();
    curl_setopt($link, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($link, CURLOPT_RETURNTRANSFER, true);

    return $link;
?>