import React from 'react';
import ReactDOM from 'react-dom';
import './index.css';
import Dashboard from './views/Dashboard';
import * as serviceWorker from './serviceWorker';

const stats = {
  news: {
    title: "Today's tip",
    value: "The Apology of Socrates, by Plato"
  },
  keywords: {
    title: "Search rankings",
    value: [
      { title: "Keyword", value: 230 },
      { title: "Average position", value: 1234 }
    ]
  }
};

ReactDOM.render(<Dashboard stats={stats} />,
  document.getElementById('root'));

// If you want your app to work offline and load faster, you can change
// unregister() to register() below. Note this comes with some pitfalls.
// Learn more about service workers: http://bit.ly/CRA-PWA
serviceWorker.unregister();
