import makeError from './MakeError';
import log from './Log';

const setConfigMap = function (arg_map) {
    var input_map = arg_map.input_map,
    settable_map = arg_map.settable_map,
    config_map = arg_map.config_map,
    key_name, error;

    for (key_name in input_map) {
        if (input_map.hasOwnProperty(key_name)) {
            if (settable_map.hasOwnProperty(key_name)) {
                config_map[key_name] = input_map[key_name];
            } else {
                makeError('Bad Input', 
                    'Setting config key |' + key_name + '| is not supportd');
            }
        }
    }
};

export default setConfigMap;