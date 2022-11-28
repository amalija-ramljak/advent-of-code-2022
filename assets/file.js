import axios from "axios";

const fileInput = document.querySelector('input[type="file"]');

fileInput.addEventListener('input', async ({target}) => {
  const fileContent = await target.files[0].text();
  console.log({fileContent, day: target.dataset.day});

  [1, 2].forEach((i) => {
    axios
      .post(`/solution/day/${target.dataset.day}/part/${i}`, {
        fileContent
      })
      .then(({data}) => console.log(data))
  })
});
