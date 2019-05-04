import configMap from './GetGlobals';

const log = function (message, easterEgg = false) {
    if (configMap.showDebugInfos) {
        if (!easterEgg) {
            console.log(message);
        } else {
            let moo = 'mooooooooooooooooooooooooooooooooooooo'
            if (typeof message === 'string' && message.length < (moo.length - 4)) {
                moo = message + ' ' + moo.substring(0, moo.length - message.length)
            } else {
                console.log(message);
            }
            console.log('%c ________________________________________' + '\n' + 
'< ' + moo + ' >' + '\n' + 
' ----------------------------------------' + '\n' + 
'        \\   ^__^' + '\n' + 
'         \\  (oo)\\_______' + '\n' + 
'            (__)\\       )\\/\\' + '\n' + 
'                ||----w |' + '\n' + 
'|| ||', "font-family:monospace")
        }
    }
};

export default log;