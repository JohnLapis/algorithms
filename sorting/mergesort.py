from random import randint


def mergesort(array):
    if len(array) <= 1:
        return array

    mid = len(array) // 2
    left = mergesort(array[0:mid])
    right = mergesort(array[mid:])

    return merge(left, right)

def merge(left, right):
    if not left or not right:
        return left or right

    if left[0] < right[0]:
        return left[0:1] + merge(left[1:], right)
    else:
        return right[0:1] + merge(left, right[1:])


if __name__ == "__main__":
    size = 10
    array = [randint(0, size - 1) for i in range(size)]
    print(array)
    print("-----------------")
    result = mergesort(array)
    print(result)
    print(sorted(array))
    print(sorted(array) == result)
