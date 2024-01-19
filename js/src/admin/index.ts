import app from 'flarum/admin/app';

app.initializers.add('ignore-hidden-tags', () => {
    app.extensionData
        .for('nodeloc-ignore-hidden-tags')
        .registerPermission(
            {
                icon: 'fas fa-eye',
                label: app.translator.trans('ignore-hidden-tags.admin.permissions.select-group-ignore'),
                permission: 'ignorehiddentags.allowIgnoreGroup',
            },
            'moderate',
            90
        )
});
