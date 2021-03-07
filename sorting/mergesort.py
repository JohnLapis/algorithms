from random import randint


def mergesort(array):
    if len(array) <= 1:
        return array

    mid = len(array) // 2
    left = mergesort(array[0:mid])
    right = mergesort(array[mid:])

    result = []
    while left and right:
        if left[0] < right[0]:
            result.append(left[0])
            left.pop(0)
        else:
            result.append(right[0])
            right.pop(0)

    result.extend(left if left else right)

    return result

if __name__ == "__main__":
    size = 10
    array = [randint(0, size - 1) for i in range(size)]
    print(array)
    print("-----------------")
    result = mergesort(array)
    print(result)
    print(sorted(array))
    print(sorted(array) == result)
