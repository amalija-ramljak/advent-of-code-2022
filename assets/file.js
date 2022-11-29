import axios from "axios";

const fileInput = document.querySelector('input[type="file"]');
const solutionElements = {
  part1: document.querySelector('#part-one strong'),
  part2: document.querySelector('#part-two strong'),
}

fileInput.addEventListener('input', async ({target}) => {
  const fileContent = await target.files[0].text();

  [1, 2].forEach((i) => {
    axios
      .post(`/solution/day/${target.dataset.day}/part/${i}`, {
          fileContent,
          test: 1
        }
      )
      .then(({ data: { solution } }) => {
        const partName = `part${i}`;
        solutionElements[partName].innerText = solution[partName];
      })
  })
});
