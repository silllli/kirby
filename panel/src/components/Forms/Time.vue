<template>
  <div class="k-time">
    <div
      v-for="(range, rangeKey) in times"
      :key="rangeKey"
      :class="'k-time-' + rangeKey"
    >
      <k-headline>{{ range.label }}</k-headline>
      <ul>
        <li v-for="time in range.times" :key="time">
          <template v-if="time !== '-'">
            <button @click="select(time + ':00')">{{ time }}:00</button>
            <nav>
              <button @click="select(time + ':15')">:15</button>
              <button @click="select(time + ':30')">:30</button>
              <button @click="select(time + ':45')">:45</button>
            </nav>
          </template>
        </li>
      </ul>
    </div>
  </div>
</template>

<script>
/**
 * The Time component is mainly used for our `TimeInput` dropdown.
 * @public
 *
 * @example <k-time value="12:12" @input="onInput" />
 */
export default {
  props: {
    /**
     * Time
     * @example `07:30`
     */
    value: String
  },
  computed: {
    times() {
      return {
        day: {
          label: "Day",
          times: [
            "06",
            "07",
            "08",
            "09",
            "10",
            "11",
            "-",
            "12",
            "13",
            "14",
            "15",
            "16",
            "17"
          ]
        },
        night: {
          label: "Night",
          times: [
            "18",
            "19",
            "20",
            "21",
            "22",
            "23",
            "-",
            "00",
            "01",
            "02",
            "03",
            "04",
            "05"
          ]
        }
      };
    }
  },
  methods: {
    select(time) {
      this.$emit("input", time);
    }
  }
};
</script>

<style>
.k-time {
  display: grid;
  grid-template-columns: 1fr 1fr;
}
.k-time > div {
  padding: 0.5rem 0;
}
.k-time .k-headline {
  padding: 0 1rem;
  font-size: var(--text-xs);
  color: var(--color-gray-400);
  margin-bottom: 0.5rem;
  font-weight: var(--font-normal);
}
.k-time-day {
  border-right: 1px solid var(--color-dark);
}
.k-time li {
  position: relative;
  min-height: 0.625rem;
}
.k-time button {
  padding: 0.325rem 5.5rem 0.325rem 1rem;
  font-variant-numeric: tabular-nums;
  font-size: var(--text-sm);
  text-align: left;
  color: currentColor;
}
.k-time li nav {
  position: absolute;
  display: none;
  left: 4rem;
  top: 0;
  bottom: 0;
  background: var(--color-white);
  border-radius: var(--rounded);
  box-shadow: var(--shadow-xl);
  color: var(--color-black);
  z-index: 1;
}
.k-time li:hover nav {
  display: flex;
}
.k-time li nav button {
  padding: 0.25rem 0.5rem;
  font-size: var(--text-xs);
}
.k-time li nav button:not(:last-child) {
  border-right: 1px solid var(--color-light);
}
</style>
