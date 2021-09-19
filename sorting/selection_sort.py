def sort(array):
    if len(array) <= 1: return array

    minIdx, minNum = 0, array[0]
    for i in range(len(array)):
        if array[i] < minNum:
            minIdx, minNum = i, array[i]

    if minIdx == 0:
        sortedSubArray = sort(array[1:])
        sortedSubArray.insert(0, minNum)
        pass
    else:
        array[minIdx] = array[0]
        sortedSubArray = sort(array[1:])
        sortedSubArray.insert(0, minNum)

    return sortedSubArray
