<?php


namespace Nodeloc\IgnoreHiddenTags\Provider;

use Flarum\Foundation\AbstractServiceProvider;
use Nodeloc\IgnoreHiddenTags\Filter\IgnoreHiddenTagsFromAllDiscussionsPage;
use Flarum\Discussion\Filter\DiscussionFilterer;

class IgnoreServiceProvider extends AbstractServiceProvider
{
    public function register()
    {
        $this->container->extend('flarum.filter.filter_mutators', function (&$mutators) {
            $filtererClass = DiscussionFilterer::class;
            if (isset($mutators[$filtererClass])) {
                $index = array_search("Flarum\Tags\Filter\HideHiddenTagsFromAllDiscussionsPage", $mutators[$filtererClass]);
                if ($index !== false) {
                    unset($mutators[$filtererClass][$index]);
                }
            }
            // 添加你自己的过滤器变换器
            $mutators[$filtererClass][] = $this->container->make(IgnoreHiddenTagsFromAllDiscussionsPage::class);
            return $mutators;
        });
    }
}
