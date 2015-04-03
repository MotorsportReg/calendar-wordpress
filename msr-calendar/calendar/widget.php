<?php

$req_url=get_option('msr_calendar_url');
$cache_update_after_time=get_option('msr_calendar_cache_time') * 60 * 60;

$data=request_cache($req_url,$cache_update_after_time);

echo msr_calendar_view($data);
