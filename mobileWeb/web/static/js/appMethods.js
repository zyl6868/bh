history.back = function () {
	try {
		if (BHWEB.appGoBack && typeof(BHWEB.appGoBack) === "function") {
			BHWEB.appGoBack();
		} else {
			history.go(-1);
		}
	} catch(e) {
		history.go(-1);
	}
};

