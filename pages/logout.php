<?php

session_destroy();
header('Location: ' . $basePath . '/');
exit;