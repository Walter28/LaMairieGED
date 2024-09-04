declare class Diff {
    constructor(options?: {});
    toString(): string;
    setValue(aKey: string | number, aValue: string | number | boolean | number[] | {
        [key: string]: string | {
            [key: string]: string;
        };
    } | elementNodeType): this;
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
type diffType = {
    [key: string | number]: string | number | boolean | number[] | {
        [key: string]: string | {
            [key: string]: string;
        };
    } | elementNodeType;
};

declare function nodeToObj(aNode: Element, options?: DiffDOMOptionsPartial): elementNodeType;

declare const stringToObj: (html: string, options?: DiffDOMOptionsPartial) => nodeType;

declare class DiffDOM {
    options: DiffDOMOptions;
    constructor(options?: DiffDOMOptionsPartial);
    apply(tree: Element, diffs: (Diff | diffType)[]): boolean;
    undo(tree: Element, diffs: (Diff | diffType)[]): void;
    diff(t1Node: string | elementNodeType | Element, t2Node: string | elementNodeType | Element): Diff[];
}

/**
 * Use TraceLogger to figure out function calls inside
 * JS objects by wrapping an object with a TraceLogger
 * instance.
 *
 * Pretty-prints the call trace (using unicode box code)
 * when tracelogger.toString() is called.
 */
/**
 * Wrap an object by calling new TraceLogger(obj)
 *
 * If you're familiar with Python decorators, this
 * does roughly the same thing, adding pre/post
 * call hook logging calls so that you can see
 * what's going on.
 */
declare class TraceLogger {
    messages: string[];
    pad: string;
    padding: string;
    tick: number;
    constructor(obj?: {});
    fin(fn: string, args: string | HTMLElement | number | boolean | false | (string | HTMLElement | number | boolean | false)[]): void;
    fout(fn: string, result: string | HTMLElement | number | boolean | false | (string | HTMLElement | number | boolean | false)[]): void;
    format(s: string, tick: number): string;
    log(...args: any[]): void;
    toString(): string;
}

export { DiffDOM, TraceLogger, nodeToObj, stringToObj };
