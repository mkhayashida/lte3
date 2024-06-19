<template>
  <div class="main">
    <div v-if="loading">Loading...</div>
    <div v-else>
      <h1>魔法の鏡チャレンジ</h1>
      <div class="flex-head">
        <div class="image-frame">
          <img :src="mirrorPng"/>
        </div>
        <span>累計{{skunkCount}}回ハズレ！</span>
      </div>
      <div class="passed-time">
        <div class="time">{{ timePassed }} 前に大当たりが出ました</div>
      </div>

      <div class="users">
        <div class="flex-mid">
          <img :src="`https://cdn.17app.co/THUMBNAIL_${senderPicture}`" />
          {{senderName}}が大当たり！
        </div>
        <div class="flex-mid">
          <img :src="`https://cdn.17app.co/THUMBNAIL_${receiverPicture}`" />
          {{receiverName}}に贈りました
        </div>
      </div>

      <div class="rank-frame">
        <table class="rank-table">
          <tr v-for="user in rank">
            <td class="ta-r" width="1">{{user.rank}}位</td>
            <td>{{user.userInfo.displayName}}</td>
            <td class="ta-r" width="1">{{user.score}}</td>
          </tr>
        </table>
      </div>

    </div>
  </div>
</template>

<script>
import mirrorPng from '../../img/mirror.png';

export default {
  name: 'SnowWhite',
  data() {
    return {
      luckyBagData: null,
      loading: true,
      rankData: null,
      rankLoading: null,
      intervalId: null,
      timerId: null,
      timePassed: '00:00:00',
      mirrorPng
    };
  },
  mounted() {
    this.fetchLuckyBagData();
    this.intervalId = setInterval(this.fetchLuckyBagData, 10000);
  },
  beforeUnmount() {
    clearInterval(this.intervalId);
  },
  computed: {
    data() {
      return this.luckyBagData;
    },
    skunkCount() {
      return this.data?.skunkCount;
    },
    timestamp() {
      return this.data?.jackpot.timestamp;
    },
    sender() {
      return this.data?.jackpot.sender;
    },
    senderName() {
      return this.sender?.displayName;
    },
    senderPicture() {
      return this.sender?.picture;
    },
    receiver() {
      return this.data?.jackpot.receiver;
    },
    receiverName() {
      return this.receiver?.displayName;
    },
    receiverPicture() {
      return this.receiver?.picture;
    },
    rank() {
      return this.rankData;
    }
  },
  methods: {
    fetchLuckyBagData() {
      // Fetch lucky bag data
      fetch('/jackpot', {
        method: 'GET',
        referrerPolicy: 'no-referrer-when-downgrade'
      })
          .then(response => response.json())
          .then(data => {
            const luckyBags = data.luckyBags;
            const filteredLuckyBags = luckyBags.find(bag => bag.giftID === '2406_jp_snowwhite_bag_sc');
            this.luckyBagData = filteredLuckyBags || null;
            if (this.luckyBagData) {
              this.timestamp = this.luckyBagData.timestamp;
              this.updateTimePassed();
              if (this.timerId) {
                clearInterval(this.timerId);
              }
              this.timerId = setInterval(this.updateTimePassed, 1000);
            }
            this.loading = false;
          })
          .catch(error => {
            console.error('Error fetching lucky bag data:', error);
            this.loading = false;
          });

      // Fetch rank data
      fetch('/rank', {
        method: 'GET',
        referrerPolicy: 'no-referrer-when-downgrade'
      })
          .then(response => response.json())
          .then(data => {
            this.rankData = data.data;
            this.rankLoading = false;
          })
          .catch(error => {
            console.error('Error fetching rank data:', error);
            this.rankLoading = false;
          });
    },
    updateTimePassed() {
      if (!this.timestamp) {
        this.timePassed = '00:00:00';
        return;
      }
      const now = Date.now();
      const past = new Date(this.timestamp * 1000).getTime(); // assuming the timestamp is in seconds
      const diff = now - past;

      const hours = Math.floor(diff / 1000 / 60 / 60);
      const minutes = Math.floor((diff / 1000 / 60) % 60);
      const seconds = Math.floor((diff / 1000) % 60);

      this.timePassed = `${String(hours).padStart(2, '0')}:${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`;
    }
  }
};
</script>

<style scoped>
h1 {
  font-size: 12px;
  text-align: center;
}
.flex-head {
  display: flex;
  align-items: center;
  align-content: center;
  justify-content: center;
}
.flex-mid {
  display: flex;
  align-items: center;
  align-content: center;
  margin-bottom: 5px;
}
.image-frame {
  background: #fff;
  border-radius: 5px;
  border: 2px solid #fff;
  margin-right: 10px;
}
.image-frame img {
  display: block;
  width: 30px
}
.passed-time {
  text-align: center;
  margin-top: 10px;
}
.flex-mid img {
  width: 23px;
  border-radius: 50%;
  border: 2px solid #ddd;
  margin-right: 5px;
}
.time {
  margin-bottom: 10px;
}
.custom-select {
  padding-right: 2.5rem; /* Adjust as needed */
  background: url('data:image/svg+xml;charset=US-ASCII,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 4 5"><path fill="%23343a40" d="M2 0L0 2h4zm0 5L0 3h4z"/></svg>') no-repeat right 0.75rem center;
  background-size: 8px 10px;
}
.users {
  background: #777;
  padding: 5px 15px;
}
.rank-frame {
  margin: 20px auto;
  width: 95%;
  background: #555;
  border-radius: 4px;
  padding-bottom: 10px;
}
.rank-table {
  width: 100%;
  padding: 4px;
}
.rank-table td {
  padding: 3px;
  border-bottom: 1px dotted #666;
  white-space: nowrap;
}
.ta-r {
  text-align: right;
}
.main {
  max-width: 500px;
  margin: 0 auto;
}
</style>