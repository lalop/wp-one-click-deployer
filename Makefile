
build:
	rm -rf one-click-deployer
	cp -R src one-click-deployer
	rm one-click-deployer/.DS_Store
	cp LICENSE one-click-deployer/
	cp README.md one-click-deployer/
	cp demo.gif one-click-deployer/
	zip -r one-click-deployer.zip one-click-deployer
