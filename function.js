function isEmpty(str) {
    return (str.trim() == '')
}

function debounce(func, delay) {
    let timerId;
    return function(...args) {
        clearTimeout(timerId);
        timerId = setTimeout(() => {
            func.apply(this, args);
        }, delay);
    };
}

function sleep(ms) {
    return new Promise(resolve => setTimeout(resolve, ms))
}