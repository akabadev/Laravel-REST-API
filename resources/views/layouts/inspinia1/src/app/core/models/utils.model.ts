export type AtLeast<T, K extends keyof T> = Partial<T> & Pick<T, K>;

export interface IPageConfig {
  /** Label de la ressource */
  ressourceLabel: string;
  /** Base URI */
  baseURI: string;
  /** Informations sur les champs de la liste */
  columns: IColumnInfos[];
  /** Liste des actions disponible pour l'utilisateur */
  actions: {
    update?: IActionColumn;
    create?: IActionColumn;
    delete?: IActionColumn;
  };
  /** Config du formulaire */
  form: IFormConfig;
}

export interface IColumnInfos {
  /** Le titre de la colonne */
  header: string;
  /** La clef du champ */
  field: string;
  /** Le type du champ */
  type: 'string' | 'number' | 'boolean' | 'object';
  /** Si type est object, la regex pour afficher l'objet (ex: "{{code}} - {{name}}") */
  displayName?: string;
  /** Le champ possède un formulaire de recherche */
  searchable?: boolean;
  /** Le contenu provient d'une liste  */
  isList?: boolean;
  /** Si isList est true, l'url pour récupérer la liste */
  listUrl?: string;
}

export interface IFormConfig {
  [key: string]: {
    /** Le libellé du champ */
    label: string;
    /** Le type du champ */
    type: 'string' | 'number' | 'boolean' | 'object';
    /** Les validateurs pour le champ  formulaire d'ajout / d'édition */
    rules?: string[];
    /** L'utilisateur peut modifier le champ dans formulaire d'ajout / d'édition */
    canEdit?: boolean;
    /** En cas de type object, on peut  ajouter les enfants modifiable */
    children?: IFormConfig;
  };
}

interface IActionColumn {
  label: string;
}
