<template>
  
    <div class="menu">
          <label for="search" class="col-form-label">Содержит: </label>
          <input type="text" class="form-control search" v-model="search" >
        
          <label for="search" class="col-form-label">Бюджет от: </label>
          <input type="text" class="form-control search" style="width: 100px;" v-model="minBudget" >
          <label for="search" class="col-form-label">до: </label>
          <input type="text" class="form-control search" style="width: 100px;" v-model="maxBudget" >
      
    </div>
  
  <div class="container-fluid content">    
    <div class="projects">
      <div class="project" v-for="project in filteredProjects" :key="project.id" @click="selectProject(project.id)" :data-active="project.id===editID">
        <div class="project__name" v-html="highlightedSearch(project.attributes.name)"></div>
        <div class="project__budget" v-if="project.attributes.budget!==null">          
          <span class="project__budget__value" >{{project.attributes.budget.amount}} {{project.attributes.budget.currency}}</span>
        </div>
        <div class="skills">
          <div class="skill" v-for="skill in project.attributes.skills" :key="skill.id" :data-id="skill.id">{{skill.name}}</div>
        </div>
      </div>
    </div>    
  </div>

  <div v-if="editID" class="projectCard">
    <div class="projectCard__date">{{currentProject.attributes.published_at.split('T')[0]}}</div>
    <div class="projectCard__description" v-html="highlightedSearch(currentProject.attributes.description)"></div>
    <a class="projectCard__link" :href="currentProject.links.self.web" target="_blank">{{currentProject.links.self.web}}</a>
  </div>
  
</template>

<script lang="js">

 
export default {
  data() {
    return {
      projects: [],
      editID: 0,
      search: '',
      minBudget: '',  
      maxBudget: '',
    }
  },  
  methods: {
    loadData: async function () {
      let domain = window.location.hostname === 'localhost' ? 'https://fhtest.loc' : ''; 
      let response = await fetch(domain + '/api.php?request=projects');
      return await response.json();
    },
    selectProject(id) {
      this.editID = id;
    },    
  },
  async created() {
    this.projects = await this.loadData();
    console.log('this.projects', this.projects);
  },
  computed: {
    preparedSearch() {
      return this.search.trim().toLowerCase();
    },    
    isSearchMatch() {
      return function (project) {
        if (!this.preparedSearch) {
          return true;
        }
        return project.attributes.name.toLowerCase().includes(this.preparedSearch) || project.attributes.description.toLowerCase().includes(this.preparedSearch);
      }
    },
    isMinBudgetMatch() {
      return function (project) {
        if (!this.minBudget) {
          return true;
        }
        if (this.minBudget && project.attributes.budget === null) {
          return false;
        }
        return project.attributes.budget.amount >= parseInt(this.minBudget);
      }
    },    
    isMaxBudgetMatch() {
      return function (project) {
        if (!this.maxBudget) {
          return true;
        }
        if (this.maxBudget && project.attributes.budget === null) {
          return false;
        }
        return project.attributes.budget.amount <= parseInt(this.maxBudget);
      }
    },
    highlightedSearch() {
      return function (text) {
        if (!this.preparedSearch) {
          return text;
        }
        return text.replace(new RegExp(this.preparedSearch, 'gi'), (match) => {
          return '<span class="highlight">' + match + '</span>';
        });
      }
    },
    currentProject() {
      return this.projects.find(project => project.id === this.editID);
    },
    filteredProjects() {      
      if (!this.preparedSearch && !this.minBudget && !this.maxBudget) {
        return this.projects;
      }
      return this.projects.filter((project) => {
          return this.isSearchMatch(project) && this.isMinBudgetMatch(project) && this.isMaxBudgetMatch(project);          
      });
    }
  },
  
  setup() {
    return {}
  }
}
</script>

<style>
 body {
   margin: 0;
 }
 .highlight {
   background: yellow;
 }
</style>

<style scoped>
.menu {
  width: 100%;
  display: flex;
  justify-content: flex-start;
  margin-bottom: 20px;
  position: fixed;
  top: 0;
  background: aliceblue;
  padding: 10px;
  z-index: 99;
}
.search {
  /* min max and percent */
  width: 300px;
  margin-left: 10px;
  margin-right: 20px;
}

.content {
  margin-top: 80px;    
}
.projects {
  flex: 1;
  width: 70%;
  margin-left: 0;
}
.project {  
  padding: 10px;
  margin-bottom: 2px;
  transition: all .3s ease-in-out;
  border-radius: 8px 0 0 8px;
  
}
.project[data-active="true"] {
  background: #f0f0f0;
  transition: all .05s ease-in-out;
}
.project:hover {  
  background: linear-gradient(90deg, #dedede 0%, #f0f0f0 100%);
  cursor: pointer;
  transition: all .3s ease-in-out;
}

.project__name {
  display: inline-block;
  font-weight: bold;
  font-size: 16px;
  flex-basis: calc(5% - 10px); /* Задать ширину элемента в 50%, учитывая отступы */
  flex-grow: 1;  
  margin: 5px;
}
.project__budget {
  display: inline-block;
  flex-grow: 1;
  
  margin: 5px;
}

.skills {
  display: flex;
  flex-wrap: wrap;
  gap: 10px;
  margin: 5px 0 5px;
  flex-basis: calc(100% - 10px);
}
.skill {
  background: #EAEDF6;
  border-radius: 8px;
  padding: 3px 6px;
  font-size: 12px;
  font-style: normal;
  font-weight: 400;
  line-height: 100%;
  color: #2c3e50;
  position: relative;
}

.projectCard {  
  padding: 30px;
  background: #fff;
  border: #f0f0f0 10px solid;
  position: fixed;
  right: 0px;
  top: 58px;
  height: calc(100vh - 58px);
  width: 35%;
  overflow-y: auto;
}
.projectCard__date {
  font-size: 12px;
  color: #999;
  margin-bottom: 20px;
  background: #EAEDF6;
  display: inline-block;
  padding: 5px 10px;
  border-radius: 8px;
}


</style>
