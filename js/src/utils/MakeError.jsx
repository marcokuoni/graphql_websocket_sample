import configMap from './GetGlobals';
import log from './Log';
const makeError = function (name_text, msg_text, data) {
	const error = new Error();
	error.name = name_text;
	error.message = JSON.stringify(msg_text);

	if (data) {
		error.data = data;
	}


    if (!configMap.productivMode) {
		if (configMap.showDebugInfos) {
			log(name_text);
			log(msg_text);
			log(data);
		} else {
			throw error;
		}
	}
};

export default makeError;