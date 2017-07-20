<?php
$user = GWF_User::current();
$module = Module_News::instance();

echo $module->renderTabs();

# List with cards
echo $response->getHTML();
