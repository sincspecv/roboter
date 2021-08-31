const elementExists = element => {
    if((NodeList.prototype.isPrototypeOf(element) ||  HTMLCollection.prototype.isPrototypeOf(element)) && element.length <= 0) {
        return false
    }
    if(typeof(element) !== undefined && element !== null) {
        return true
    }
    return false
}
export {
    elementExists,
}
