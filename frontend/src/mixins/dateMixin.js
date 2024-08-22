import { format } from 'date-fns';

export const dateMixin = {
  methods: {
    formatDate(date) {
      return date ? format(new Date(date), "dd/MM/yyyy") : "";
    }
  }
};
