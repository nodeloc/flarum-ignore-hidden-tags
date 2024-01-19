import app from 'flarum/forum/app';

app.initializers.add('nodeloc/flarum-ignore-hidden-tags', () => {
  console.log('[nodeloc/flarum-ignore-hidden-tags] Hello, forum!');
});
