export default class HelperClass {
    findElementInObjectsArray(epsArray, epsArrayAttribute,elementToBeFound) {
        let result = epsArray.find(element => element[epsArrayAttribute] === elementToBeFound)
        return result;
    }
    filterElementsInObjectsArray(epsArray, epsArrayAttribute,elementToBeFiltered){
        let result = epsArray.filter(obj => obj[epsArrayAttribute] === elementToBeFiltered)
        return result;
    }
}
