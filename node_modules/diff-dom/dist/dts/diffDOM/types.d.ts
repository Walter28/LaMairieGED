import { Diff } from "./helpers";
interface subsetType {
    oldValue: number;
    newValue: number;
    length: number;
    delete?: true;
}
interface elementNodeType {
    nodeName: string;
    attributes?: {
        [key: string]: string;
    };
    childNodes?: nodeType[];
    checked?: boolean;
    value?: string | number;
    selected?: boolean;
}
interface textNodeType {
    nodeName: "#text" | "#comment";
    data: string;
    childNodes?: never;
}
type nodeType = elementNodeType | textNodeType;
interface elementDiffNodeType extends elementNodeType {
    childNodes?: diffNodeType[];
    subsets?: subsetType[];
    subsetsAge?: number;
    outerDone?: boolean;
    innerDone?: boolean;
    valueDone?: boolean;
}
interface textDiffNodeType extends textNodeType {
    outerDone?: boolean;
}
type diffNodeType = elementDiffNodeType | textDiffNodeType;
interface Document {
    createElement: (arg: string) => Element;
    createElementNS: (namespaceURI: string, qualifiedName: string) => Element;
    createTextNode: (arg: string) => Text;
    createComment: (arg: string) => Comment;
}
type PreDiffApply = (PreDiffApplyOptions: any) => boolean;
type PostDiffApply = (PostDiffApplyOptions: any) => void;
interface ConstNames {
    addAttribute: string | number;
    modifyAttribute: string | number;
    removeAttribute: string | number;
    modifyTextElement: string | number;
    relocateGroup: string | number;
    removeElement: string | number;
    addElement: string | number;
    removeTextElement: string | number;
    addTextElement: string | number;
    replaceElement: string | number;
    modifyValue: string | number;
    modifyChecked: string | number;
    modifySelected: string | number;
    modifyComment: string | number;
    action: string | number;
    route: string | number;
    oldValue: string | number;
    newValue: string | number;
    element: string | number;
    group: string | number;
    groupLength: string | number;
    from: string | number;
    to: string | number;
    name: string | number;
    value: string | number;
    data: string | number;
    attributes: string | number;
    nodeName: string | number;
    childNodes: string | number;
    checked: string | number;
    selected: string | number;
}
interface DiffDOMOptions {
    debug: boolean;
    diffcap: number;
    maxDepth: number | false;
    maxChildCount: number;
    valueDiffing: boolean;
    caseSensitive: boolean;
    textDiff: (node: textNodeType | Text | Comment, currentValue: string, expectedValue: string, newValue: string) => void;
    preVirtualDiffApply: PreDiffApply;
    postVirtualDiffApply: PostDiffApply;
    preDiffApply: PreDiffApply;
    postDiffApply: PostDiffApply;
    filterOuterDiff: null | ((t1: any, t2: any, diffs: Diff[]) => void | Diff[]);
    compress: boolean;
    _const: ConstNames;
    document: Document;
    components: string[];
}
type DiffDOMOptionsPartial = Partial<DiffDOMOptions>;
type ConstNamesPartial = Partial<ConstNames>;
type diffType = {
    [key: string | number]: string | number | boolean | number[] | {
        [key: string]: string | {
            [key: string]: string;
        };
    } | elementNodeType;
};
export { nodeType, ConstNames, ConstNamesPartial, DiffDOMOptions, DiffDOMOptionsPartial, diffType, diffNodeType, elementDiffNodeType, elementNodeType, subsetType, textDiffNodeType, textNodeType, };
