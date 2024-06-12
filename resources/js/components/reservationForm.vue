<template>
  <form action="/form-example" method="POST" class="w-75">
    <div class="form-group">
      <label for="textInput">タイトル <span class="text-danger">*</span></label>
      <input type="text" class="form-control" id="textInput" name="textInput" placeholder="Enter text">
    </div>

    <div class="form-group">
      <label for="textInput">生成種別 <span class="text-danger">*</span></label>
      <select class="form-control custom-select pr-2" id="selectInput" name="selectInput">
        <option value="option1">缶汎用</option>
        <option value="option2">ペットボトル汎用</option>
        <option value="option3">Zone</option>
        <option value="option3">のんある気分</option>
        <option value="option3">田中正光</option>
      </select>
    </div>

    <div class="card bg-secondary p-3 mt-2">
      <button type="button" class="btn btn-default btn-sm mb-2 position-absolute" style="right:16px; top: 10px" @click="jsonFormSwitch">
        {{isJsonInput ? 'フォーム入力' : 'json入力'}}
      </button>

      <div v-if="isJsonInput">
        <div class="form-group">
          <label>
            json入力
          </label>
          <textarea
              class="form-control mb-3"
              v-model="jsonInput"
              rows="10"
              placeholder="Enter text"
          ></textarea>

          <div v-if="hasJsonError" class="alert alert-danger mb-3">
            JSONが間違ってます。
          </div>

          <div class="d-flex justify-content-end">
            <button type="button" class="btn btn-outline-dark btn-sm" @click="parseJson">実行</button>
          </div>
        </div>
      </div>
      <div id="dynamic-inputs" v-else>
        <div v-for="(item, index) in formData" :key="index">
          <div class="p-3 border border-dark mt-5 position-relative pt-4">
            <label>コンセプト</label>
            <input
                class="form-control"
                v-model="item.concept"
                placeholder="Concept"
                @input="stringify"
            />

            <div v-for="(prompt, pIndex) in item.prompts" :key="pIndex" class="mt-3">
              <div class="card p-4 mt-2" style="background: rgba(255,255,255,0.07)">
                <div class="form-group">
                  <label>モチーフ</label>
                  <input
                      class="form-control"
                      type="text"
                      v-model="prompt.motif"
                      placeholder="Motif"
                      @input="stringify"
                  />
                </div>
                <div class="form-group">
                  <label>
                    プロンプト <span class="text-danger">*</span>
                  </label>
                  <textarea
                      class="form-control"
                      v-model="prompt.prompt"
                      rows="5"
                      placeholder="Prompt"
                      @input="stringify"
                  ></textarea>
                  <div v-if="pIndex > 0" class="input-group-append justify-content-end mt-1">
                    <button
                        v-if="pIndex > 0"
                        type="button"
                        style="right: 10px; top: 10px;"
                        class="btn btn-outline-dark btn-sm position-absolute"
                        @click="deletePrompt(index, pIndex)">ー</button>
                  </div>
                </div>
              </div>
            </div>

            <button
                v-if="index > 0"
                type="button"
                style="right: 10px; top: 10px;"
                class="btn btn-outline-dark btn-sm position-absolute"
                @click="deleteMainItem(index)">
              コンセプト
              <i class="fas fa-minus-square"></i>
            </button>

            <button
                type="button"
                class="btn btn-default float-right"
                @click="addPrompt(index)">＋</button>
            <div class="clearfix"></div>
          </div>

        </div>
        <button
            type="button"
            style="margin: 0 auto; display: block"
            class="btn btn-outline-dark mt-4 mb-4"
            @click="addMainItem">コンセプト ＋</button>
      </div>
    </div>

    <button class="btn btn-dark btn-sm mb-2" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
      オプション
    </button>

    <!-- Collapsible content -->
    <div class="collapse mb-2" id="collapseExample">
      <div class="card bg-secondary p-3">
        Generation
        <div class="custom-control custom-checkbox form-group">
          <input class="custom-control-input custom-control-input-dark " type="checkbox" id="customCheckbox5" checked="">
          <label for="customCheckbox5" class="custom-control-label">デフォルト値を使用する</label>
        </div>

        <div class="form-group">
          <label for="numberInput">sampling steps</label>
          <input type="number" class="form-control" id="numberInput" name="numberInput" placeholder="Enter number">
        </div>

        <div class="form-group">
          <label for="textInput">生成種別 <span class="text-danger">*</span></label>
          <select class="form-control custom-select" id="selectInput" name="selectInput">
            <option value="option1">Euler a</option>
            <option value="option1">Euler b</option>
            <option value="option1">Euler c</option>
          </select>
        </div>

        <div class="form-group">
          <label for="numberInput">width</label>
          <input type="number" class="form-control" id="numberInput" name="numberInput" placeholder="Enter number">
        </div>

        <div class="form-group">
          <label for="numberInput">height</label>
          <input type="number" class="form-control" id="numberInput" name="numberInput" placeholder="Enter number">
        </div>

        <div class="form-group">
          <label for="numberInput">CF scale</label>
          <input type="number" class="form-control" id="numberInput" name="numberInput" placeholder="Enter number">
        </div>

        <div>ControlNet <span class="text-danger">*</span></div>
        <div class="custom-control custom-checkbox form-group">
          <input class="custom-control-input custom-control-input-dark " type="checkbox" id="customCheckbox5" checked="">
          <label for="customCheckbox5" class="custom-control-label">デフォルト値を使用する</label>
        </div>

        <div class="form-group">
          <label for="textInput">Control Type</label>
          <select class="form-control custom-select" id="selectInput" name="selectInput">
            <option value="option1">depth</option>
            <option value="option1">aaa</option>
            <option value="option1">bbb</option>
          </select>
        </div>

        <div class="form-group">
          <label for="numberInput">control weight</label>
          <input type="number" class="form-control" id="numberInput" name="numberInput" placeholder="Enter number">
        </div>

        <div class="form-group">
          <label for="numberInput">starting control step</label>
          <input type="number" class="form-control" id="numberInput" name="numberInput" placeholder="Enter number">
        </div>

        <div class="form-group">
          <label for="numberInput">ending control step</label>
          <input type="number" class="form-control" id="numberInput" name="numberInput" placeholder="Enter number">
        </div>

        <div class="form-group">
          <label for="textInput">control mode</label>
          <select class="form-control custom-select" id="selectInput" name="selectInput">
            <option value="option1">Balanced</option>
            <option value="option1">aaa</option>
            <option value="option1">bbb</option>
          </select>
        </div>

        <div class="form-group">
          <label for="fileInput">Upload File</label>
          <input type="file" class="form-control-file" id="fileInput" accept="image/*">
        </div>

        <div>
          <img id="preview" src="" alt="File Preview" style="display: none; width: 200px;">
        </div>
      </div>
    </div>

    <div class="form-group mt-2">
      <label for="textInput">Miroボード名</label>
      <input type="text" class="form-control" id="textInput" name="textInput" placeholder="Enter text">
    </div>

    <button type="submit" class="btn btn-primary mt-3">生成</button>
  </form>
</template>

<script>
export default {
  name: 'ReservationForm',
  data() {
    return {
      isJsonInput: true,
      jsonInput: '',
      formData: [
        {
          "concept":"",
          "prompts": [
            {
              "motif": "",
              "prompt": ""
            },
            {
              "motif": "",
              "prompt": ""
            }
          ]
        }
      ]
    };
  },
  mounted() {
    this.stringify();
  },
  methods: {
    parseJson() {
      try {
        this.formData = JSON.parse(this.jsonInput);
      } catch (e) {
        console.error("Invalid JSON");
        alert('Invalid JSON input. Please correct it and try again.');
      }
    },
    stringify() {
      this.jsonInput = JSON.stringify(this.formData, null, 2);
    },
    addPrompt(index) {
      this.formData[index].prompts.push({ motif: "", prompt: "" });
    },
    deletePrompt(mainIndex, promptIndex) {
      this.formData[mainIndex].prompts.splice(promptIndex, 1);
    },
    addMainItem() {
      this.formData.push({
        concept: "",
        prompts: [{ motif: "", prompt: "" }]
      });
    },
    deleteMainItem(index) {
      this.formData.splice(index, 1);
    },
    jsonFormSwitch() {
      this.isJsonInput = !this.isJsonInput;

      if (this.isJsonInput) {
        //this.jsonFromInputs();
      }
    },
  }
};
</script>

<style scoped>
.custom-select {
  padding-right: 2.5rem; /* Adjust as needed */
  background: url('data:image/svg+xml;charset=US-ASCII,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 4 5"><path fill="%23343a40" d="M2 0L0 2h4zm0 5L0 3h4z"/></svg>') no-repeat right 0.75rem center;
  background-size: 8px 10px;
}
</style>