#coding: utf-8
#TODO: Implementar aqui scripts de instalação e configuração do Composer e PHPUnit no MAMP.
import os
import json
import platform
from getpass import getuser
from subprocess import check_output

bash_file = ""
user = getuser()
if 'Linux' in platform.system():
	bash_file = "/home/%s/.bash_rc" % user
else: 
	bash_file = "/Users/%s/.bash_profile" % user
bash_file_content = open(bash_file).read()

def setup():
	#dict vars
	config = json.loads(open('config.json', 'r').read())
	#string vars
	path = config['PATH'].replace("${PHP_VERSION}", config['PHP_VERSION']).replace("$PATH",os.environ['PATH'])
	navigate_command = "cd %s" % config['PHP_PATH']
	curl_command = "curl -sS %s | php" % config['COMPOSER_URL']
	composer_path = config['COMPOSER_PATH'].replace("${PHP_VERSION}", config['PHP_VERSION'])
	#list vars
	env_vars = ['PHP_VERSION=%s' % config['PHP_VERSION'],
				"alias composer='php %s'" % config['COMPOSER_PATH'].replace("${PHP_VERSION}", config['PHP_VERSION']),
				"export PATH=%s" % path]
	
	for env_var in env_vars:
		if not already_has_system_var(env_var):
			print('\n %s not in environment variables. Adding...' % env_var)
			add_env_variable(env_var)
		else:
			print('\n environment variable "%s" already created' % env_var)
	

	if not composer_is_installed(composer_path):
		print('\n Executing %s \n\n' %  curl_command)
		execute_command("%s && %s" % (navigate_command, curl_command))
	
	execute_command('source %s' % bash_file)
	print('setup complete!')

def add_env_variable(env_var):
	command = 'echo "\n%s" >> %s && source %s' % (env_var, bash_file, bash_file)
	print('\n Executing %s \n\n' % command)
	execute_command(command)	

def composer_is_installed(composer_path):
	already_installed = False
	try:
		print('\n looking for Composer in path %s' % composer_path)
		f = open(composer_path, 'r')
		already_installed = f is not None
		print("Composer is already installed. Skipping installation")
	except Exception, e:
		print('Composer not installed.')
	return already_installed

def already_has_system_var(system_var):
	return system_var in bash_file_content


def execute_command(command_text):
	return check_output(command_text, shell=True)


if __name__ == '__main__':
	if 'Windows' in platform.system():
		print('Sorry, only unix allowed. =/ ')
	setup()