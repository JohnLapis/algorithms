<?php

require_once("dfs.php");

function get_printable_array($array) {
    return implode(", ", $array);
}

function print_graph($graph) {
    echo "Nodes: " . get_printable_array($graph["nodes"]) . "\n";
    echo "Edges: "
        . get_printable_array(
            array_map(function($e) {return implode("-", $e);}, $graph["edges"])
        )
        . "\n";
}

$graph = [
    "nodes" => ["a", "b", "c", "d", "e"],
    "edges" => [["a", "b"], ["b", "d"], ["e", "a"]],
];

print_graph($graph);

list("found"=>$found, "visited"=>$visited) = dfs($graph, $graph["nodes"][0], "b");
echo "Found: $found\n";
echo "Visited: " . get_printable_array($visited) . "\n";
