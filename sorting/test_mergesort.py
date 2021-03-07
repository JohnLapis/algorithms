from hypothesis import given, strategies as st
from mergesort import mergesort


@given(st.lists(st.integers()))
def test_mergesort(array):
    assert mergesort(array) == sorted(array)
