from math import inf


# The indexing starts at 1
def max_heapify(heap, idx, heap_size=None):
    if heap_size is None:
        heap_size = len(heap)
    if heap_size <= 1: return heap

    max_idx = max(
        # parent, left,  right nodes
        [idx,     2*idx, 2*idx + 1],
        key=lambda i: heap[i-1] if i-1 < heap_size else -inf
    )
    if max_idx == idx:
        return heap
    else:
        heap[idx-1], heap[max_idx-1] = heap[max_idx-1], heap[idx-1]
        return max_heapify(heap, max_idx, heap_size)

def make_max_heap(array):
    for i in range(len(array) // 2, 0, -1):
        array = max_heapify(array, i)

    return array

def heapsort(array):
    heap = make_max_heap(array)
    heap_size = len(heap)
    for i in range(len(heap), 1, -1):
        heap[i-1], heap[0] = heap[0], heap[i-1]
        heap_size -= 1
        heap = max_heapify(heap, 1, heap_size)

    return heap
