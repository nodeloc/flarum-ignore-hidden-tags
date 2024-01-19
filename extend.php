<?php

use Flarum\Api\Serializer\ForumSerializer;
use Flarum\Discussion\Filter\DiscussionFilterer;
use Flarum\Extend;
use Nodeloc\IgnoreHiddenTags\Filter\IgnoreHiddenTagsFromAllDiscussionsPage;
use Nodeloc\IgnoreHiddenTags\Provider\IgnoreServiceProvider;

return [
    (new Extend\Frontend('admin'))
        ->js(__DIR__.'/js/dist/admin.js'),
    new Extend\Locales(__DIR__.'/locale'),
    (new Extend\Filter(DiscussionFilterer::class))
        ->addFilterMutator(IgnoreHiddenTagsFromAllDiscussionsPage::class),
    (new Extend\ServiceProvider())->register(IgnoreServiceProvider::class),
    (new Extend\ApiSerializer(ForumSerializer::class))
        ->attribute('allowIgnoreGroup', function (ForumSerializer $serializer) {
            return $serializer->getActor()->hasPermission("ignorehiddentags.allowIgnoreGroup");
        }),
];
