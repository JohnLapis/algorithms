#include <stdio.h>
#define N 3
#define M 3
#define NAME_MAX 10

struct name {
  char text[NAME_MAX];
};

struct choice {
  struct name student;
  struct name university;
}

struct student {
  struct name name;
  struct university preferences[M];
};

struct university {
  struct name name;
  struct student suitors[N];
  int max_suitors;
  int number_of_chosen_suitors = 0;
  struct student preferences[N];
};

struct student[] find_choices_for_uni(struct choice choices[], struct university uni) {
  struct student possible_suitors[N];
  int i = 0;
  for (int j = 0; j < N; ++j) {
    if (choices[j].university == uni) {
      possible_suitors[i] = choices[j].student;
      ++i;
    }
  }

  return possible_suitors;
}

struct student find_best_suitor_for_uni(struct student suitors[], struct univesity uni) {
  for (int i = 0; i < N; ++i) {
    struct student uni.preferences[i];
    if (contains(suitors, preffered_suitor)) {
      return preffered_suitor;
    }
  }
}

void add_suitor(struct student suitor, struct university uni) {
  uni.suitors[uni.number_of_chosen_suitors] = suitor;
  ++uni.number_of_chosen_suitors;
}

int algorithm(struct student students[], struct university universities[]) {
  int students_enrolled = 0;
  student uni_suitors[M];
  /* for (int i = 0; i < M; ++i) { */
  /*   uni_suitors[hash(universities[i].name)] = []; */
  /* } */

  while (students_enrolled < N) {
    struct choice first_options[N];
    for (int i = 0; i < N; ++i) {
      struct student s = students[i];
      struct university uni = s.preferences[0];
      first_options[i] = {s.name, uni.name};
      /* j = findpos(uni, universities) */
      /* uni_suitors[j] = s; */
    }

    for (int i = 0; i < M; ++i) {
      struct university uni = universities[i];
      struct student possible_suitors[] = find_choices_for_uni(first_options, uni);
      struct student best_suitor = find_best_suitor_for_uni(possible_suitors, uni);

      for (int j; j < N; ++j) {
        struct student suitor = possible_suitors[j];
        if (suitor != best_suitor) {
          suitor.preferences = remove_first_element(suitor.preferences);
         /* remove_first_element(suitor.preferences); */
        }
      }

      if (uni.number_of_chosen_suitors < uni.max_suitors) {
        add_suitor(best_suitor, uni);
        ++enrolled_students;
        continue;
      }

      int worst_index = find_index_of_worst_suitor_for_uni(uni.suitors, uni);
      struct student worst_suitor = uni.suitors[worst_index];
      if (best_suitor == find_best_suitor_for_uni([worst_suitor, best_suitor], uni)) {
        uni.suitors[worst_index] = best_suitor;
        worst_suitor.preferences = remove_first_element(worst_suitor.preferences);
      }
    }
  }
  return 0;
}

int main(int argc, char *argv[]) {
  /* struct student s1 = {"s1", {}, {}}, s2 = {"s2", {}, {}}, s3 = {"s3", {}, {}}; */
  /* struct university u1 = {"u1", {}, {}}, u2 = {"u2", {}, {}}, u3 = {"u3", {}, {}}; */

  /* s1.preferences = [u1, u3, u2]; */
  /* s2.preferences = [u1, u2, u3]; */
  /* s3.preferences = [u3, u1, u2]; */

  /* u1.preferences = [s1, s2, s3]; */
  /* u2.preferences = [s1, s2, s3]; */
  /* u3.preferences = [s3, s1, s2]; */

  struct student students[N] = {
      {"s1", {}, ["u1", "u3", "u2"]},
      {"s2", {}, ["u1", "u2", "u3"]},
      {"s3", {}, ["u3", "u1", "u2"]},
  };
  struct university universities[M] = {
      {"u1", {}, ["s1", "s3", "s2"]},
      {"u2", {}, ["s1", "s2", "s3"]},
      {"u3", {}, ["s3", "s1", "s2"]},
  };

  return main(students, universities);
}
