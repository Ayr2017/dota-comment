

function getTimeDiff(startTime, currentTime) {
    let createdTime = new Date(startTime).getTime();
    let timezone = (new Date(currentTime)).getTimezoneOffset();
    let timeDifference = parseInt((currentTime - (createdTime /* + timezone * 60000 */)) / 1000);
    if (timeDifference < 60) {
        return `${parseInt(timeDifference)} сек. назад`;
    } else if (timeDifference < 3600) {
        return `${parseInt(timeDifference / 60)} мин. назад`;
    } else if (timeDifference < 3600 * 24) {
        return `${parseInt(timeDifference / 3600)} час. назад`;
    } else if (timeDifference < 3600 * 24 * 30) {
        return `${parseInt(timeDifference / 60 / 60 / 24)} дн. назад`;
    }
}

export default getTimeDiff;