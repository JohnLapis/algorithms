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

function dfs($graph, $cur, $value) {
    /** Depth-first search of graph starting at some node. */
    $visited = [$cur];

    if ($cur === $value) {
        return [
            "found" => TRUE,
            "visited" => $visited
        ];
    }

    foreach (get_neighbour_nodes($graph, $cur) as $node) {
        $res = dfs($graph, $node, $value);
        $visited = array_merge($visited, $res["visited"]);
        if ($res["found"]) break;
    }

    return [
        "found" => count($visited) <= count($graph["nodes"]),
        "visited" => $visited
    ];
}
