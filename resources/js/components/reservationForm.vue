<template>
  <form action="/form-example" method="POST" class="w-50">
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

    <div>
      <span>プロンプト入力</span>
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
              v-model="json"
              rows="10"
              placeholder="Enter text"
          ></textarea>

          <div v-if="hasJsonError" class="alert alert-danger mb-3">
            JSONが間違ってます。
          </div>

          <div class="d-flex justify-content-end">
            <button type="button" class="btn btn-outline-dark btn-sm" @click="parseJsonInput">実行</button>
          </div>
        </div>
      </div>
      <div id="dynamic-inputs" v-else>
        <div v-for="(input, index) in inputs" :key="input.id" :id="'new-' + input.id">
          <hr v-if="index > 0" style="border-color: #333;" class="mt-1" />
          <div class="form-group">
            <label :for="'textInput' + input.id">モチーフ</label>
            <input
                type="text"
                class="form-control"
                :id="'textInput' + input.id"
                v-model="input.motif"
                placeholder="Enter text"
            />
          </div>
          <div class="form-group">
            <label :for="'textareaInput' + input.id">
              プロンプト <span class="text-danger">*</span>
            </label>
            <textarea
                class="form-control"
                :id="'textareaInput' + input.id"
                v-model="input.prompt"
                rows="5"
                placeholder="Enter text"
            ></textarea>
            <div v-if="index > 0" class="input-group-append justify-content-end mt-1">
              <button type="button" class="btn btn-outline-dark btn-sm" @click="removeInputGroup(input.id)">ー</button>
            </div>
          </div>
        </div>

        <div class="d-flex justify-content-end">
          <button type="button" class="btn btn-outline-dark align" id="add-input" @click="addInput">＋表現モチーフ追加</button>
        </div>
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
      inputCount: 1,
      isJsonInput: true,
      hasJsonError: false,
      json: '',
      inputs: [
        {
          "motif": "",
          "prompt": ""
        }
      ]
    };
  },
  mounted() {
    this.jsonFromInputs();
  },
  computed: {
  },
  methods: {
    addInput() {
      this.inputCount++;
      this.inputs.push({ id: this.inputCount, motif: '', prompt: '' });
    },
    removeInputGroup(id) {
      this.inputs = this.inputs.filter(input => input.id !== id);
    },
    jsonFormSwitch() {
      this.isJsonInput = !this.isJsonInput;

      if (this.isJsonInput) {
        this.jsonFromInputs();
      }
    },
    parseJsonInput() {
      try {
        const inputArray = JSON.parse(this.json);

        // Generate the new JSON with id parameter
        this.inputs = inputArray.map((item, index) => ({
          id: index + 1,
          ...item
        }));

        this.jsonFormSwitch();
        this.hasJsonError = false;
      } catch (error) {
        this.hasJsonError = true;
      }
    },
    jsonFromInputs() {
      try {
        // Generate the new JSON with id parameter
        const array = this.inputs.map((item, index) => ({
          motif: item.motif,
          prompt: item.prompt
        }));

        this.json = JSON.stringify(array, null, 2);
      } catch (error) {
        console.error('Invalid JSON:', error);
        alert('Invalid JSON input. Please correct it and try again.');
      }
    }
  }
}
</script>

<style scoped>
.custom-select {
  padding-right: 2.5rem; /* Adjust as needed */
  background: url('data:image/svg+xml;charset=US-ASCII,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 4 5"><path fill="%23343a40" d="M2 0L0 2h4zm0 5L0 3h4z"/></svg>') no-repeat right 0.75rem center;
  background-size: 8px 10px;
}
</style>
