# config valid only for current version of Capistrano
lock '3.4.0'

set :application, 'grandprix.run'
set :repo_url, 'git@github.com:mreeves1/grandprix.run.git'
set :branch, 'master'
set :deploy_to, '/var/www/grandprix.run'

# Default branch is :master
# ask :branch, `git rev-parse --abbrev-ref HEAD`.chomp

# Default deploy_to directory is /var/www/my_app_name
# set :deploy_to, '/var/www/my_app_name'

# Default value for :scm is :git
# set :scm, :git

# Default value for :format is :pretty
# set :format, :pretty

# Default value for :log_level is :debug
# set :log_level, :debug

# Default value for :pty is false
# set :pty, true

# Default value for :linked_files is []
# set :linked_files, fetch(:linked_files, []).push('config/database.yml', 'config/secrets.yml')
set :linked_files, fetch(:linked_files, []).push('.env')

# Default value for linked_dirs is []
# set :linked_dirs, fetch(:linked_dirs, []).push('log', 'tmp/pids', 'tmp/cache', 'tmp/sockets', 'vendor/bundle', 'public/system')

# Default value for default_env is {}
# set :default_env, { path: "/opt/ruby/bin:$PATH" }

# Default value for keep_releases is 5
# set :keep_releases, 5

namespace :deploy do

  task :composer_setup do
    on roles(:web), in: :groups, limit: 3, wait: 10 do
      print "Setting up composer and laravel"

      execute "php /usr/local/bin/composer.phar install --working-dir #{release_path} --no-interaction"
      execute "cd #{release_path}; php artisan clear-compiled"
      execute "cd #{release_path}; php artisan optimize"
      execute "cd #{release_path}; php artisan migrate"
    end
  end

  task :restart do
    on roles(:web), in: :groups, limit: 3, wait: 10 do
      print "Restarting Nginx webserver and php 7 fpm manager..."
      
      execute :sudo, "service nginx reload"
      execute :sudo, "service php7.0-fpm reload"
    end
  end

  after "deploy:finished", "deploy:composer_setup"
  after "deploy:composer_setup","deploy:restart"

end
