merge(Left, [], Left):- !.
merge([], Right, Right):- !.
merge([LH|LT], [RH|RT], NewList):-
    (LH < RH; LH =:= RH),
    merge(LT, [RH|RT], Rest),
    !,
    append([LH], Rest, NewList).
merge([LH|LT], [RH|RT], NewList):-
    RH < LH,
    merge([LH|LT], RT, Rest),
    !,
    append([RH], Rest, NewList).


split_list(Xs, Ys, Zs) :-
    length(Xs, N),
    H is N - N // 2,
    length(Ys, H),
    append(Ys, Zs, Xs).

mergesort([], []):- !.
mergesort([X], [X]):- !.
mergesort(List, Sorted):-
    split_list(List, Left, Right),
    mergesort(Left, SortedLeft),
    mergesort(Right, SortedRight),
    !,
    merge(SortedLeft, SortedRight, Sorted).
