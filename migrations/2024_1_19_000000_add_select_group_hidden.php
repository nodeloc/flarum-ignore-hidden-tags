<?php

use Flarum\Database\Migration;
use Flarum\Group\Group;

return Migration::addPermissions([
    'ignorehiddentags.allowIgnoreGroup' => Group::MEMBER_ID
]);
