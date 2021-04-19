<?php

function get_neighbour_nodes($graph, $node) {
    $incident_edges = array_filter(
        $graph["edges"], function($e) use ($node) {return in_array($node, $e);}
    );
    return array_map(
        function($e) use ($node) {return $node == $e[0] ? $e[1] : $e[0];},
        $incident_edges
    );
}

function bfs($graph, $node, $value) {
    /** Breadth-first search of graph starting at some node. */
    $visited = [];
    $queue = [$node];
    while ($queue) {
        $cur = array_shift($queue);
        if (in_array($cur, $visited)) continue;
        array_push($visited, $cur);
        if ($value === $cur) break;
        $queue = array_merge($queue, get_neighbour_nodes($graph, $cur));
    }

    return [
        "found" => count($visited) <= count($graph["nodes"]),
        "visited" => $visited
    ];
}
