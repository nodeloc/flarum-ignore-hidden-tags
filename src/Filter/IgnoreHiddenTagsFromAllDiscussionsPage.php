<?php
namespace Nodeloc\IgnoreHiddenTags;

use Flarum\Filter\FilterState;
use Flarum\Query\QueryCriteria;
use Flarum\Tags\Tag;
use Flarum\Tags\Filter\HideHiddenTagsFromAllDiscussionsPage;

class IgnoreHiddenTagsFromAllDiscussionsPage extends HideHiddenTagsFromAllDiscussionsPage
{
    public function __invoke(FilterState $filter, QueryCriteria $queryCriteria)
    {
        if (count($filter->getActiveFilters()) > 0) {
            return;
        }

        $filter->getQuery()->where(function ($query) {
            $query->whereNotIn('discussions.id', function ($query) {
                return $query->select('discussion_id')
                    ->from('discussion_tag')
                    ->whereIn('tag_id', Tag::where('is_hidden', 1)->pluck('id'))
                    ->whereNotExists(function ($query) {
                        // 这个子查询用于获取有特定权限的用户的 ID
                        return $query->selectRaw('1')
                            ->from('users')
                            ->join('group_user', 'group_user.user_id', '=', 'users.id')
                            ->join('groups', 'groups.id', '=', 'group_user.group_id')
                            ->join('group_permission', 'group_permission.group_id', '=', 'groups.id')
                            ->where('group_permission.permission', 'ignorehiddentags.allowIgnoreGroup')
                            ->whereRaw('users.id = discussions.user_id');
                    });
            });
        });
    }
}
