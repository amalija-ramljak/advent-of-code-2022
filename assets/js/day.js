import "../css/day.scss";

import axios from "axios";

const fileInput = document.querySelector('input[type="file"]');
const fileName = document.querySelector('.file-input .file-name span');
const solutionElements = {
  part1: document.querySelector('#part-one strong'),
  part2: document.querySelector('#part-two strong'),
}

fileInput.addEventListener('input', async ({target}) => {
  const file = target.files[0];
  fileName.innerText = file.name;
  fileName.parentElement.classList.add('show');

  const fileContent = await file.text();
  [1, 2].forEach((i) => {
    const partName = `part${i}`;
    solutionElements[partName].innerText = "...";

    axios
      .post(`/solution/day/${target.dataset.day}/part/${i}`, {
          fileContent,
          test: 1
        }
      )
      .then(({ data: { solution, error } }) => {
        if (error) {
          solutionElements[partName].innerText = error;
        } else {
          solutionElements[partName].innerText = solution[partName] ?? "No result (yet)";
        }
      })
  })
});
