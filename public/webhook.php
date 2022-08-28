<?php
  $pwd = getcwd();
  // 2>&1 是输出错误，有利于调试
  $command = 'cd ' . $pwd . ' && git pull origin master 2>&1'; 
  $output = shell_exec($command);
  // 输出内容保存到日志，需要注意日志文件要有足够的权限
  file_put_contents('./webhook.log', $output);
  print $output;
?>
