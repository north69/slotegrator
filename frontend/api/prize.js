import axios from "axios";

export default {
  create() {
    return axios.post("/api/prizes");
  },
  get() {
    return axios.get("/api/prizes");
  },
};