import argparse
from operator import itemgetter
from pprint import pprint

import yaml


def main(men, women):
    day = 0
    while True:
        favorites = []
        for w in women:
            suitors = list(filter(lambda m: m["preferences"][0] == w["name"], men))
            if suitors:
                # the smaller the index, the greater the preference
                w["favorite"] = min(
                    suitors, key=lambda s: w["preferences"].index(s["name"])
                )
                favorites.append(w["favorite"])

        # remove most preffered woman for all rejected men
        for m in men:
            if m not in favorites:
                m["preferences"].pop(0)

        day += 1

        if len(favorites) == len(women):
            break

    return {
        "day": day,
        "matchings": [
            (w.get("favorite", {"name": ""})["name"], w["name"]) for w in women
        ],
    }


if __name__ == "__main__":
    parser = argparse.ArgumentParser(
        description="Implementation of Gale-Shapley algorithm."
    )
    parser.add_argument(
        "participants",
        type=str,
        help="YAML file with the names of the men and women and their preferences.",
    )
    args = parser.parse_args()
    with open(args.participants, "r") as f:
        men, women = itemgetter("men", "women")(yaml.safe_load(f))

    day, matchings = itemgetter("day", "matchings")(main(men, women))
    print(f"It took {day} days.")
    print("----------------------------------------")
    for m in matchings:
        print(m[0] + " - " + m[1])
